<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateMusicRequest;
use App\Http\Requests\UpdateMusicRequest;
use App\models\Category;
use App\models\Music;
use App\models\Like;
use Storage;

class MusicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->all();
        $music_model = new Music();
        $music_query = $music_model->query()->select('music.*',  'u.id as user_id', 'u.image as user_image', 'u.name as user_name', 'c.name as category_name')
          ->where('music.status', 1)
          ->join('users as u', 'music.user_id', '=', 'u.id')
          ->join('categories as c', 'music.category_id', '=', 'c.id');

        if( !empty($params['title']) ) {
          $title = $params['title'];
          $music_query->where(function($query) use ($title, $params) {
            $query->orWhere('music.title', 'like', "%$title%")->orWhere('music.description', 'like', "%$title%");
          });
        }
        if(!empty($params['category'])){
          $music_query->where('c.id', $params['category']);
        }
        if(!empty($params['order'])){
          $music_query->orderBy('music.created_at', $params['order']);
        } else {
          $music_query->orderBy('music.created_at', 'desc');
        }
        $music = $music_query->paginate(12);

        $categories = Category::orderBy('id', 'ASC')->get();

        return view('music.index', compact('music', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $categories = Category::orderBy('id', 'ASC')->get();
      return view('music.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMusicRequest $request)
    {
      $posts = $request->all();
      $posts['music']['user_id'] = \Auth::id();
      // mp3と画像のアップロード
      $image = $request->file('music.image');
      if(!empty($image)){
          // バケットの`music/images`フォルダへアップロード
          $path = Storage::disk('s3')->putFile("music/images", $image, 'public');
          // アップロードした画像のフルパスを取得
          $posts['music']['image'] = config('app.s3_url').$path;
      }else{
          $posts['music']['image'] = null;
      }

      $mp3 = $request->file('music.mp3');
      if(!empty($mp3)){
          // バケットの`music/mp3s`フォルダへアップロード
          $path = Storage::disk('s3')->putFile("music/mp3s", $mp3, 'public');
          // アップロードした画像のフルパスを取得
          $posts['music']['mp3'] = config('app.s3_url').$path;
      }
      Music::insert($posts['music']);

      return redirect( route('home') )->with('success', 'フレーズの投稿が完了しました。');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $music = Music::select('music.*', 'users.name AS user_name', 'categories.name AS category_name')
          ->join('users', 'users.id', '=', 'music.user_id')
          ->join('categories', 'categories.id', '=', 'music.category_id')
          ->findOrFail($id);
        $liked = Like::where('music_id', $id)->where('user_id', \Auth::id())->exists();
        return view('music.show', compact('music', 'liked'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $music = Music::where('id', $id)->where('user_id', \Auth::id())->firstOrFail();
        $categories = Category::orderBy('id', 'ASC')->get();

        return view('music.edit', compact('music', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMusicRequest $request, $id)
    {
      $posts = $request->all();
      // ファイルアップは音楽フレーズ投稿と同じ
      $image = $request->file('music.image');
      if(!empty($image)){
          // バケットの`music/images`フォルダへアップロード
          $path = Storage::disk('s3')->putFile("music/images", $image, 'public');
          // アップロードした画像のフルパスを取得
          $posts['music']['image'] = config('app.s3_url').$path;
      }
      $mp3 = $request->file('music.mp3');
      if(!empty($mp3)){
          // バケットの`music/mp3s`フォルダへアップロード
          $path = Storage::disk('s3')->putFile("music/mp3s", $mp3, 'public');
          // アップロードした画像のフルパスを取得
          $posts['music']['mp3'] = config('app.s3_url').$path;
      }

      Music::where('id', $id)->update($posts['music']);

      return redirect( route('music.show', ['id' => $id]) )->with('success', 'フレーズの編集が完了しました。');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $music = Music::find($id);
        // 念の為本人確認
        // もしフレーズの持ち主とログインユーザーが異なれば削除せずにリダイレクト
        if($music['user_id'] != \Auth::id()){
            return redirect(route('home'))->with('danger', '他人のフレーズは削除できません。');
        }
        Music::where('id', $id)->update(['status' => 2]);
        return redirect(route('home'))->with('success', 'フレーズの削除が完了しました！');
    }

    public function download($id){
        $music = Music::findOrFail($id);
        $ext = explode('.', $music['mp3']);
        $ext = end($ext);
        $file = explode('/', $music['mp3']);
        $content = \Storage::disk('s3')->get("$file[3]/$file[4]/$file[5]");
        $contentType = \Storage::disk('s3')->mimeType("$file[3]/$file[4]/$file[5]");
        $filename = $music['title'].'.'.$ext;

        $headers = [
            'Content-Type' => $contentType,
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => "attachment; filename={$filename}",
            'filename' => $filename,
        ];

        return response($content, 200, $headers);
    }

    public function ajaxLike(Request $request)
    {
        $posts = $request->all();
          \Log::debug(print_r($posts, true));
        if( !\Auth::user() ){
          return redirect('/login');
        }
        // likesテーブルにデータがあった場合（すでにいいね！されていた場合）
        if( Like::where('music_id', $posts['id'])->where('user_id', $posts['user_id'])->exists() ){
            Like::where('music_id', $posts['id'])->where('user_id', $posts['user_id'])->delete();
            return response()->json(['status' => true, 'result' => 'dislike']);
        }else{
          \Log::debug(print_r($posts['id'], true));
        // likesテーブルにデータがない場合（いいね！されていない場合）
            Like::insert(['music_id' => $posts['id'], 'user_id' => $posts['user_id']]);
            return response()->json(['status' => true, 'result' => 'like']);
        }
    }
}


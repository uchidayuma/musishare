<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateMusicRequest;
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
    public function index()
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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


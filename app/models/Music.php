<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Music extends Model
{
    public function getPopular(){
        $popular = $this->select('music.*', 'u.id as user_id', 'u.image as user_image', 'u.name as user_name', 'c.name as category_name', DB::raw('COUNT(*) as count'))
          ->where('music.status', 1) // 1=アクティブ 2なら削除すみなので、取得しない
          ->join('users as u', 'music.user_id', '=', 'u.id')
          ->join('categories as c', 'music.category_id', '=', 'c.id')
          ->leftJoin('likes as l', 'l.music_id', '=', 'music.id')
          ->limit(3) // トップページは3つだけでOK
          ->orderBy('count', 'DESC') //いいねが多い順
          ->groupBy('music.id')
          ->get();
          
        return $popular;
    }
    
    public function getLatest($limit=null){
        $latest = $this->select('music.*',  'u.id as user_id', 'u.image as user_image', 'u.name as user_name', 'c.name as category_name')
          ->where('music.status', 1)
          ->join('users as u', 'music.user_id', '=', 'u.id')
          ->join('categories as c', 'music.category_id', '=', 'c.id')
          ->limit($limit)
          ->orderBy('music.created_at', 'DESC')
          ->get();

        return $latest;
    }
}

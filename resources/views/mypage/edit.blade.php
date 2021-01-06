@extends('layouts.app')

@section('css')
<link href="{{ asset('css/mypage.css') }}" rel="stylesheet">   
@endsection

@section('javascript')
<script src="{{ asset('js/mypage/edit.js') }}" defer></script>
@endsection

@section('content')
<h1 class='color-main bold text-center mt-5 mb-4'>プロフィール編集</h1>
<form class="card profile" action="/mypage/update" method="POST" enctype="multipart/form-data">
  @csrf
  @method('patch')
  <h5 class="card-header">プロフィール情報</h5>
  <div class="card-body overflow-hidden">
    <h5 class="card-title profile__title">プロフィール画像</h5>
    <div class='row mb-3'>
      <div class='col-md-12 col-lg-5'>
        <img id='profile__image' class="profile__image" src="{{ empty($user->image) ? '/images/user-icon.png' : $user->image }}" >
      </div>
      <div class='col-md-12 col-lg-7'>
        <div class="form-group">
          <input name="user[image]" type="file" class="form-control-file" onchange="previewImage(this);">
        </div>
      </div>
    </div>
    <h5 class="card-title profile__title">ニックネーム</h5>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon1">@</span>
      </div>
      <input name="user[name]" type="text" class="form-control profile__name" placeholder="ユーザー名" aria-label="ユーザー名" aria-describedby="basic-addon1" value="{{ $user->name }}">
    </div>
    <h5 class="card-title profile__title">自己紹介</h5>
    <div class="form-group">
      <textarea name="user[description]" class="form-control profile__description" rows="3" placeholder="自己紹介を入力">{{ $user->description }}</textarea>
    </div>
    <button class="btn btn-success profile__submit">プロフィール情報を更新</button>
  </div>
</form>
<a href="/password/change" class='d-block text-center mt-4 mb-5'>パスワードの変更はこちら</a>
<h2 class='color-accent bold text-center mb-4'>アカウントの削除</h2>
<button class='btn btn-secondary btn-lg d-block m-auto'>削除</button>
@endsection
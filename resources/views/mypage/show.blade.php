@extends('layouts.app')

@section('css')
<link href="{{ asset('css/mypage.css') }}" rel="stylesheet">   
@endsection

@section('content')
<h1 class='color-main bold text-center mt-5 mb-4'>{{ $user['name'] }}さんのプロフィール</h1>
<section class='bg-white'>
  <div class='row p-lg-5 p-3'>
    <div class='col-md-12 col-lg-3 text-center'>
      <img id='profile__image' class="profile__image" src="{{ empty($user->image) ? '/images/user-icon.png' : $user->image }}" >
    </div>
    <div class='col-md-12 col-lg-9'>
      <p class='h3 text-dark font-weight-bold'>{{ $user['name'] }}</p>
      <p class='h4 text-dark'>{{ $user['description'] }}</p>
    </div>
  </div>
</section>
<section class=' p-lg-5 p-3'>
  <h2 class='color-main bold text-center '>投稿作品</h2>
  投稿フレーズ一覧
</section>
@endsection
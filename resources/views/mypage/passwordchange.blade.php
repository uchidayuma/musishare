@extends('layouts.app')

@section('css')
<link href="{{ asset('css/mypage.css') }}" rel="stylesheet">   
@endsection

@section('content')
<h1 class='color-main bold text-center mt-5 mb-5'>パスワード変更</h1>
<form class="" action="/mypage/password/change" method="POST">
  @csrf
  @method('patch')
  <div class="form-group">
    <input name='password' type="password" class="form-control w-50 mx-auto mb-4" placeholder="現在のパスワード">
    <input name='new-password' type="password" class="form-control w-50 mx-auto mb-3" placeholder="新しいパスワード">
    <input name='new-password-confirm' type="password" class="form-control w-50 mx-auto mb-5" placeholder="新しいパスワード確認">
  </div>
  <button class='btn btn-primary btn-lg d-block m-auto'>パスワード変更を確定</button>
</form>
@endsection
@extends('layouts.app')

@section('css')
<link href="{{ asset('css/home.css') }}" rel="stylesheet">   
<link href="{{ asset('css/components/music-card.css') }}" rel="stylesheet">   
@endsection

@section('content')
<a href="#" class="banner-wrapper d-block text-center mb-3 mt-3"><img class="banner" src="{{ asset('images/dummy-banner.png') }}"></a>
<a href="#" class="banner-wrapper d-block text-center mb-5"><img class="banner" src="{{ asset('images/dummy-banner.png') }}"></a>
<section class="popular">
  <div class="container">
    <h2 class="color-main bold mb-4 text-center">人気のフレーズ</h2>
    <div class="row music-row justify-content-between mb-5">
  @foreach($popular AS $m)
      <div class="col-11 col-sm-11 col-md-11 col-lg-4">
        @include('components.music-card')
      </div> <!-- col -->
  @endforeach
    </div>
  </div>
</section>
<section class="public bg-yellow pt-5">
  <div class="container">
    <h2 class="color-main bold mb-4 text-center">公開中のフレーズ</h2>
    <div class="row music-row justify-content-between mb-5">
  @foreach($latest AS $m)
      <div class="col-11 col-sm-11 col-md-11 col-lg-4">
        @include('components.music-card') 
      </div> <!-- col -->
  @endforeach
    </div>
    <p class='text-center mb-0'><a href="#" class='list-link btn btn-danger'>音楽フレーズ一覧</a></p>
  </div><!-- container -->
</section>
@endsection


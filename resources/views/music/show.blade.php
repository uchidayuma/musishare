@extends('layouts.app')

@section('css')
<link href="{{ asset('css/music/show.css') }}" rel="stylesheet">   
@endsection

@section('javascript')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{ asset('library/audiojs/audio.min.js') }}"></script>
<script>
  audiojs.events.ready(function() {
    var as = audiojs.createAll();
  });
</script>
<script src="{{ asset('js/music/show.js') }}" defer></script>
@endsection

@section('content')
<nav aria-label="breadcrumb" class='mb-5'>
  <ol class="breadcrumb bg-white">
    <li class="breadcrumb-item"><a href="/">ホーム</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $music['title'] }}</li>
  </ol>
</nav>
<section class='music bg-white p-lg-5'>
  <div class='row title-row mb-3 w-100'>
    <h1 class='music__title color-main bold'>{{ $music['title'] }}</h1>
    <p class='color-accent bold ml-auto'>{{ $music['category_name'] }}</p>
  </div>
  <div class='row mb-3'>
    <div class='col-md-12 col-lg-6'>
      <img id='music__image' class="music__image" src="{{ empty($music['image']) ? '/images/music-dummy.jpg' : $music['image'] }}" >
    </div>
    <div class='col-md-12 col-lg-6'>
      <p>{{ nl2br($music['description']) }}</p>
    </div>
  </div>
  <div class='row mb-3'>
    <div class='col-md-12 col-lg-6 text-center'>
    <a class='music__download' href="{{ route('music.download', ['id' => $music['id']])}}" target="blank"><i class="fas fa-cloud-download-alt mr-1"></i>ダウンロード</a>
    @if($liked)
      <p class='music__like' onclick="like({{ $music['id'] }}, {{ $music['user_id'] }})"><i id='like-icon' class="fas fa-heart color-pink mr-1"></i>いいね！</p>
    @else
      <p class='music__like' onclick="like({{ $music['id'] }}, {{ $music['user_id'] }})"><i id='like-icon' class="far fa-heart mr-1"></i>いいね！</p>
    @endif
    </div>
    <div class='col-md-12 col-lg-6 text-center'>
      <audio src="{{ $music['mp3'] }}" preload="auto" />
    </div>
  </div>
  @if( $music['user_id'] === Auth::id() )
  <div class='row justify-content-around'>
    <a href="{{ route('music.edit', ['id' => $music['id'] ]) }}" class="btn btn-warning">編集</a> 
  </div>
  @endif
</section>
@endsection
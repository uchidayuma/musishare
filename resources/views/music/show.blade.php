@extends('layouts.app')

@section('css')
<link href="{{ asset('css/music/show.css') }}" rel="stylesheet">   
@endsection

@section('javascript')
<script src="{{ asset('library/audiojs/audio.min.js') }}"></script>
<script>
  audiojs.events.ready(function() {
    var as = audiojs.createAll();
  });
</script>
@endsection

@section('content')
<nav aria-label="breadcrumb" class='mb-5'>
  <ol class="breadcrumb bg-white">
    <li class="breadcrumb-item"><a href="/">ホーム</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $music['title'] }}</li>
  </ol>
</nav>
<section class='music bg-white p-lg-5'>
  <div class='row'>
    <h1 class='color-main bold'>{{ $music['title'] }}</h1>
    <p class='color-accent bold ml-auto'>{{$music['category_name']}}</p>
  </div>
  <div class='row'>
    <div class='col-md-12 col-lg-6 text-center'>
      <img id='music__image' class="music__image" src="{{ empty($music['image']) ? '/images/music-dummy.jpg' : $music['image'] }}" >
    </div>
    <div class='col-md-12 col-lg-6 text-center'>
      <p>{{ nl2br($music['description']) }}</p>
    </div>
  </div>
  <div class='row'>
    <div class='col-md-12 col-lg-6 text-center'>
      <a href="{{ route('music.download', ['id' => $music['id']])}}" target="blank">ダウンロード</a>
      <p>いいね！</p>
    </div>
    <div class='col-md-12 col-lg-6 text-center'>
      <audio src="{{ $music['mp3'] }}" preload="auto" />
    </div>
  </div>
</section>
@endsection
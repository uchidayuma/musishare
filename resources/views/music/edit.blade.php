@extends('layouts.app')

@section('css')
<link href="{{ asset('css/music/create.css') }}" rel="stylesheet">   
@endsection

@section('javascript')
<script src="{{ asset('js/music/create.js') }}" defer></script>
@endsection

@section('content')
<nav aria-label="breadcrumb" class='mb-5'>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/">ホーム</a></li>
    <li class="breadcrumb-item active" aria-current="page">音楽の編集</li>
  </ol>
</nav>

<form class='card form' method="POST" action="{{route('music.update', ['id' => $music['id']] )}}" enctype="multipart/form-data">
  @csrf
  <div class="card-header"></div>
  <div class="card-body overflow-hidden">
    <div class="form-group">
      <label class='form__title color-main bold' for="title">フレーズのタイトル</label>
      <input type="text" class="form-control" id="title" name='music[title]' value="{{ !empty( old('music.title') ) ? old('music.title') : $music['title'] }}" placeholder="フレーズのタイトル">
    </div>
    <div class="form-group">
      <label class='form__title color-main bold' for="category">フレーズのカテゴリー</label>
      <select class="form-control" id="category" name='music[category_id]'>
    @foreach($categories as $c)
      @if( !empty(old('music.category_id')) )
        <option value="{{ $c->id }}" {{ old('music.category_id')==$c->id ? "selected" : "" }}>{{$c->name}}</option>
      @else
        <option value="{{ $c->id }}" {{ $music['category_id']==$c->id ? "selected" : "" }}>{{$c->name}}</option>
      @endif
    @endforeach
      </select>
    </div>
    <div class="form-group">
      <label class='form__title color-main bold' for="description">フレーズの説明</label>
      <textarea class="form-control" name="music[description]" id="description" rows="5" placeholder="フレーズの説明">{{ !empty( old('music.description') ) ? old('music.description') : $music['description'] }}</textarea>
    </div>
    <div class="custom-file mb-4">
      <input type="file" class="custom-file-input" id="mp3" name="music[mp3]">
      <label class="custom-file-label" for="mp3">mp3ファイルを選択</label>
    </div>
    <label class='form__title color-main bold'>フレーズのイメージ</label>
    <div class='row mb-3'>
      <div class='col-md-12 col-lg-4'>
        <div class="form-group">
          <input name="music[image]" type="file" class="form-control-file" onchange="previewImage(this);">
        </div>
      </div>
      <div class='col-md-12 col-lg-8'>
        <img id='music_image' class="music__image" src="{{ !empty($music['image']) ? $music['image'] : '' }}" >
      </div>
    </div>
    <button type='submit' class='btn btn-primary btn-lg'>フレーズを更新</button>
  </div> <!-- card -->
</form>
@endsection
@extends('layouts.app')

@section('css')
<link href="{{ asset('css/components/music-card.css') }}" rel="stylesheet">   
<link href="{{ asset('css/music/index.css') }}" rel="stylesheet">   
@endsection

@section('content')
<h1 class='title color-main text-center bold mt-5 mb-2'>フレーズ一覧</h1>
<section class='container'>
  <p class='text-right'><button class='btn btn-secondary text-right mb-3' data-toggle="modal" data-target="#searchModal">絞り込み</button></p>
  <div class='row mb-3'>
  @foreach($music AS $m)
    <div class="col-12 col-lg-4">
      @include('components.music-card')
    </div>
  @endforeach
  </div>
  {{ $music->appends(request()->query())->links() }}
</section>
<!-- Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ route('music.index', ['title' => '', 'category' => '', 'order' => '' ]) }}" method="GET">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title color-main bold" id="searchModalLabel">絞り込み検索と並べ替え</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
              <label class='bold'>タイトルと説明文から検索</label>
              <input type="text" class="form-control" name='title' placeholder="検索したい文字を入力">
            </div>
            <div class="form-group">
              <label class='bold'>カテゴリー</label>
              <select name='category' class="form-control">
                <option value="">指定しない</option>
            @foreach($categories AS $c)
                <option value="{{ $c['id'] }}">{{ $c['name'] }}</option>
            @endforeach
              </select>
            </div>
            <div class="form-group">
              <label class='bold'>並び順</label>
              <select name='order' class="form-control">
                <option value="DESC">新しい順</option>
                <option value="ASC">古い順</option>
              </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
          <button type="submit" class="btn btn-primary">フィルターを適用</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
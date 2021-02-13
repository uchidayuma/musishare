@extends('layouts.app')

@section('content')
<a href="#" class="banner-wrapper d-block text-center mb-3 mt-3"><img class="banner" src="{{ asset('images/dummy-banner.png') }}"></a>
<a href="#" class="banner-wrapper d-block text-center mb-5"><img class="banner" src="{{ asset('images/dummy-banner.png') }}"></a>
<section class="popular">
  <div class="container">
    <h2 class="color-main bold text-center">人気のフレーズ</h2>
  </div>
</section>
<section class="public bg-yellow">
  <div class="container">
    <h2 class="color-main bold text-center">公開中のフレーズ</h2>
  </div>
</section>
@endsection


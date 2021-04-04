<div class="card music">
    <!-- 音楽フレーズのイメージ画像がなければダミーを出力 -->
    <img class='music__image' src="{{ !empty($m['image']) ? $m['image'] : asset('images/dummy-music.jpg') }}">
    <div class="card-body">
    <!-- タイトルのリンク先は音楽詳細ページ -->
    <a href="{{ route('music.show', ['id' => $m['id']] ) }}" class="card-title music__title">{{ $m['title']}}</a>
    <!-- 3行以上は3点リーダーで省略したいので、クラス名＝elipsis3を付与（_utility.scssに記述） -->
    <p class="card-text music__description elipsis3">{{ $m['description'] }}</p>
    <!-- ユーザー情報行はユーザー紹介ページへのリンクにする -->
    <a class='user' href="{{ route('mypage.show', ['id' => $m['user_id']]) }}">
        <!-- ユーザーのプロフィール画像がなければダミーを出力 -->
        <img class='user__image' src="{{ !empty($m['user_image']) ? $m['user_image'] : asset('images/user-icon.png') }}"/>
        <p class='user__name'>{{ $m['user_name'] }}</p>
    </a>
    </div> <!-- cardbody -->
</div> <!-- card -->
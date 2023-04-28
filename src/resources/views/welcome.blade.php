<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
         <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        
    </head>
    <body class="body">

<header class="header">

@if (Auth::check())
<div class="header__left">
    <button class="icon" type="button"></button>
    <div class="under__line"></div>
    <div class="menu">
        <button class="close-button" type="button">X</button>
  <div class="menu__all">
    <a href="{{ url('/dashboard') }}" class="menu__item">Home</a>
    <form class="logout" action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" class="menu__item">Logout</button>
</form>
    <a href="{{route('login')}}" class="menu__item">Mypage</a>
  </div>
@else
<div class="header__left">
    <button class="icon" type="button"><div class="third-line"></div></button>
    <div class="under__line"></div>
    <div class="menu">
        <button class="close-button" type="button">X</button>
  <div class="menu__all">
    <a href="{{ route('Home') }}" class="menu__item">Home</a>
    <a href="{{route('register')}}" class="menu__item">Registration</a>
    <a href="{{route('login')}}" class="menu__item">Login</a>
  </div>
@endif
</div>
        <div class="header__title">Rese</div>
    </div>
</div>

    <style>
  .menu {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
    transform: translateX(-100%);
    transition: transform 0.3s ease-in-out;
  }

  .close-button {
    background-color:rgb(72, 72, 255);
    color:white;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
    border:none;
    width: 40px;
    height: 40px;
    border-radius:7px;
    margin: 50px 100px;

  }

  .menu__all {
    margin: 200px 0;
  }

  .logout {
    display:flex;
    justify-content: center;
  }

  .menu__item {
    display: flex;
    justify-content: center;
    color: rgb(72, 72, 255);
    font-size: 30px;
    margin: 15px 0 ;
    text-decoration: none;
    border:none;
    background-color:white;
  }

  .menu-open {
    transform: translateX(0%);
  }
</style>

    <script>
    // ボタン要素を取得
const button = document.querySelector('.icon');

// メニュー要素を取得
const menu = document.querySelector('.menu');

// 閉じるボタン要素を取得
  const closeButton = document.querySelector('.close-button');

// ボタンがクリックされたときにメニューをスライドイン/アウトする関数
function toggleMenu() {
  menu.classList.toggle('menu-open');
}

// ボタンにクリックイベントを追加
button.addEventListener('click', toggleMenu);

// 閉じるボタンにクリックイベントを追加
  closeButton.addEventListener('click', toggleMenu);
</script>




    <div class="header__right">
 <div class="search__form">
  <form class="header__right__form" method="GET" action="{{ route('search') }}">
    <select name="area_name" class="header__right__select1">
      <option value="">All area</option>
      @foreach ($areas as $area)
        <option value="{{ $area->area_name }}">{{ $area->area_name }}</option>
      @endforeach
    </select>
    <select name="genre_name" class="header__right__select2">
      <option value="">All genre</option>
      @foreach ($genres as $genre)
        <option value="{{ $genre->genre_name }}">{{ $genre->genre_name }}</option>
      @endforeach
    </select>
    <button class="header__right__button" type="submit"><img class="header__right__img" src="/img/search.svg" alt="検索"></button>
    <input class="header__right__text" type="text" name="name" placeholder="Search...">
  </form>
</div>
</div>

</header>



<div class="card__row">
   @foreach ($shops as $shop)
    <div class="card">
        <img class="img" src="{{ $shop->picture }}" alt="{{ $shop->name }}">
        <div class="under__item">
        <div class="shopname">{{ $shop->name }}</div>
        <div class="hashtag">
        <p class="tag" > #{{ $shop->area_name }}</p>
        <p class="tag" >#{{ $shop->genre_name }}</p>
        </div>
        <div class="between">
        <a class="detail" href="{{route('detail', ['id' => $shop->shop_id])}}">詳しく見る</a>




@if (Auth::check())
<div class="heart">
    <img class="toggle_img" src="{{ $shop->isFavoritedBy(Auth::user()) ? asset('img/redheart.svg') : asset('img/grayheart.svg') }}" alt="heart" data-shopid="{{ $shop->shop_id }}" data-userid="{{ Auth::id() }}">
</div>
@endif


        </div>
        </div>
    </div>
@endforeach
</div>


<script>
$(document).on('click', '.toggle_img', function(e){
    e.preventDefault();
    
    var shop_id = $(this).data('shopid');
    var user_id = $(this).data('userid');
    var img = $(this).attr('src');

    $.ajax({
        url: "{{ route('favorite') }}",
        method: "POST",
        data:{shop_id:shop_id, user_id:user_id},
    }).done(function(data){
        if(data.status == 'success'){
            if(img.includes('grayheart.svg')){
                $('.toggle_img[data-shopid="'+shop_id+'"]').attr('src', "{{ asset('img/redheart.svg') }}");
            }else{
                $('.toggle_img[data-shopid="'+shop_id+'"]').attr('src', "{{ asset('img/grayheart.svg') }}");
            }
            console.log(data.message);
        }
    }).fail(function(){
        console.log('Error: the request was not sent!!!.');
    });
});
</script>






</body>


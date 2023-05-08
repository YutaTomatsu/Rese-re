<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/mypage.css')}}">
    <title>Document</title>
</head>
<body>
    
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
    <a href="{{route('mypage')}}" class="menu__item">Mypage</a>
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
<a class="visit" href="{{ route('reserves.past') }}">来店履歴</a>
</div>

</header>

<h2 class="name" >{{ Auth::user()->name }}さん</h2>

<div class="mypage">

<div class="reserve">
    <div class="reserve__title">予約状況</div>

    
@foreach ($reservations as $key => $reservation)
<div class="reserve__box">

<div class="confirm">
    <div class="reserve__item__top">
     <div class="reserve__item__top__left">
    <img class="time__img" src="/img/time.svg" alt="time">
        <div class="reserve__number">予約{{ $key+1 }}</div>
     </div>

     <div class="reserve__right">
     <a class="reserve__edit" href="{{route('edit', ['id' => $reservation->id])}}">予約日時を変更する</a>
     
        <a class="reserve__delete" href="{{route('delete', ['id' => $reservation->id])}}" onclick="return confirm('本当に予約を削除しますか？')"><img class="delete__img" src="/img/reserve_delete.svg" alt="delete"></a>
      </div>



    </div>
    <div class="reserve__item__bottom">
        <div class="confirm__left">
        <div class="confirm__item" >Shop</div>
        <div class="confirm__item">Date</div>
        <div class="confirm__item">Time</div>
        <div class="confirm__item">Number</div>
        </div>

        <div class="confirm__right">
        <div class="confirm__item">{{ $reservation->shop->name }}</div>
        <div class="confirm__item">{{ $reservation->date }}</div>
        <div class="confirm__item">{{ $reservation->time }}</div>
        <div class="confirm__item">{{ $reservation->number_of_people }}人</div>
        </div>
    </div>
</div>
</div>
@endforeach
</div>


<div class="favorite">
<div class="favorite__title">お気に入り店舗</div>
<div class="card__row">
   @foreach ($shops as $shop)
    <div class="card">
        <img class="img" src="{{ asset(Storage::url($shop->picture)) }}" alt="{{ $shop->name }}">
        <div class="under__item">
        <div class="shopname">{{ $shop->name }}</div>
        <div class="hashtag">
        <p class="tag" > #{{ $shop->area_name }}</p>
        <p class="tag" >#{{ $shop->genre_name }}</p>
        </div>
        <div class="between">
        <a class="detail" href="{{route('detail', ['id' => $shop->shop_id])}}">詳しく見る</a>

        
@if (in_array($shop->shop_id, $favorite_shops))
                <div class="heart">
                  <img class="toggle_img" src="{{ asset('img/redheart.svg') }}" alt="heart" data-shopid="{{ $shop->shop_id }}" data-userid="{{ Auth::id() }}">
                </div>
              @else
                <div class="heart">
                  <img class="toggle_img" src="{{ asset('img/grayheart.svg') }}" alt="heart" data-shopid="{{ $shop->shop_id }}" data-userid="{{ Auth::id() }}">
                </div>
              @endif
        </div>
        </div>
    </div>

    
@endforeach
</div>
</div>

</div>

<script>
$(document).on('click', '.toggle_img', function(e){
    e.preventDefault();
    
    var shop_id = $(this).data('shopid');
    var user_id = $(this).data('userid');
    var img = $(this).attr('src');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN':  '{{ csrf_token() }}'
        }
    });

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
</html>
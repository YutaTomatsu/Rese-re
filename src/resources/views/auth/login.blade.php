 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    
    <x-jet-authentication-card>
        <x-slot name="logo">
        </x-slot>

        <header class="header">
    <div class="header__left">

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
</header>
<main class="main">

        <form class="form" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="title">Login</div>

            <div class="center">

            <div>

            <div class="line">
                <img class="img" src="img/email.png" alt="Email">
                <x-jet-input id="email" class="item" type="email" name="email" :value="old('email')" required autofocus placeholder="Email"/>
            </div>

            <div class="line">
                <img class="img" src="img/password.png" alt="Password">
                <x-jet-input id="password" class="item" type="password" name="password" required autocomplete="current-password" placeholder="Password"/>
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="under-item">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-jet-button class="button">
                    {{ __('Log in') }}
                </x-jet-button>
            </div>
</div>
</div>
        </form>
</main>
<div class="error">
       <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif
</div>
    </x-jet-authentication-card>


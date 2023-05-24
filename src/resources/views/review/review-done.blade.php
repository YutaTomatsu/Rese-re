<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/done.css') }}">
    <title>Document</title>
</head>

<body class="background">
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
                <a href="{{ route('mypage') }}" class="menu__item">Mypage</a>
            </div>
            @else
            <div class="header__left">
                <button class="icon" type="button">
                    <div class="third-line"></div>
                </button>
                <div class="under__line"></div>
                <div class="menu">
                    <button class="close-button" type="button">X</button>
                    <div class="menu__all">
                        <a href="{{ route('Home') }}" class="menu__item">Home</a>
                        <a href="{{ route('register') }}" class="menu__item">Registration</a>
                        <a href="{{ route('login') }}" class="menu__item">Login</a>
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
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }

            .close-button {
                background-color: rgb(72, 72, 255);
                color: white;
                box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
                border: none;
                width: 40px;
                height: 40px;
                border-radius: 7px;
                margin: 50px 100px;

            }

            .menu__all {
                margin: 200px 0;
            }

            .logout {
                display: flex;
                justify-content: center;
            }

            .menu__item {
                display: flex;
                justify-content: center;
                color: rgb(72, 72, 255);
                font-size: 30px;
                margin: 15px 0;
                text-decoration: none;
                border: none;
                background-color: white;
            }

            .menu-open {
                transform: translateX(0%);
            }
        </style>

        <script>
            const button = document.querySelector('.icon');
            const menu = document.querySelector('.menu');
            const closeButton = document.querySelector('.close-button');

            function toggleMenu() {
                menu.classList.toggle('menu-open');
            }
            button.addEventListener('click', toggleMenu);
            closeButton.addEventListener('click', toggleMenu);
        </script>

        <div class="center">

            <div class="box">

                <div class="thanks">レビューの投稿が完了しました！</div>

                <a href="{{ url('/dashboard') }}" class="back">戻る</a>

            </div>

        </div>
</body>

</html>
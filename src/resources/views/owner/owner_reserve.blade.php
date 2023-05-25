<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/owner-reserve.css') }}">
    <title>Laravel</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        @if (Auth::check())
        <div class="header__left">
            <button class="icon" type="button"></button>
            <div class="under__line"></div>
            <div class="menu">
                <button class="close-button" type="button">X</button>
                <div class="menu__all">
                    <a href="{{ route('owner') }}" class="menu__item">Home</a>
                    <form class="logout" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="menu__item">Logout</button>
                    </form>
                    <a href="{{ route('owner-create') }}" class="menu__item">Create New Shop</a>
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
    </header>

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

    <div class="between">
        <div class="detail">
            <div class="detail__top">
                <h2 class="shopname">{{ $shop->name }}</h2>
            </div>
            <div class="reserve__list">
                <div class="reserve__title">
                    <h3 classa>予約一覧</h3>
                    <div class="nav__links">
                        <a class="nav__btn" href="{{ route('reserve-date', ['id' => $id, 'date' => $prev_date]) }}">
                            <</a>
                                <span>{{ $date }}</span>
                                <a class="nav__btn" href="{{ route('reserve-date', ['id' => $id, 'date' => $next_date]) }}">></a>
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th class="reserve__item">予約者</th>
                            <th class="reserve__item">日付</th>
                            <th class="reserve__item">時間</th>
                            <th class="reserve__item">人数</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reserves as $reserve)
                        <tr>
                            <td class="reserve__item">{{ $reserve->name }}</td>
                            <td class="reserve__item">{{ $reserve->date }}</td>
                            <td class="reserve__item">{{ $reserve->time }}</td>
                            <td class="reserve__item">{{ $reserve->number_of_people }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
</body>
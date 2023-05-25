<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/admin-dashboard.css') }}" rel="stylesheet">

    <title>Laravel</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">


</head>

<body class="body">

    <header class="header">

        <div class="header__left">
            <button class="icon" type="button"></button>
            <div class="under__line"></div>
            <div class="menu">
                <button class="close-button" type="button">X</button>
                <div class="menu__all">
                    <a href="{{ route('admin') }}" class="menu__item">Home</a>
                    <form class="logout" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="menu__item">Logout</button>
                    </form>
                    <a href="{{ route('mail') }}" class="menu__item">Send Mail</a>
                </div>
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


    <form class="form" method="get" action="{{ route('users.store') }}">
        @csrf

        <div class="center">
            <div class="item">
                <div class="column">

                    <div class="title">店舗代表者の作成</div>

                    <div class="item__all">

                        <div class="line">
                            <label class="item__name" for="name">Name</label>
                            <input class="shop__name__text" type="text" name="name" id="name" value="{{ old('name') }}" required>
                        </div>

                        @error('name')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <div class="line">
                            <label class="item__name" for="email">Email</label>
                            <input class="shop__name__text" type="email" name="email" id="email" value="{{ old('email') }}" required>
                        </div>

                        @error('email')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror


                        <div class="line">
                            <label class="item__name" for="password">Password</label>
                            <input class="shop__name__text" type="password" name="password" id="password" required>
                        </div>
                        @error('password')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror


                        <div class="line">
                            <label class="item__name" for="password_confirmation">Confirm Password</label>
                            <input class="shop__name__text" type="password" name="password_confirmation" id="password_confirmation" required>
                        </div>
                        @error('password_confirmation')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror


                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <button class="button" type="submit">create user</button>
    </form>

</body>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/admin-import.css') }}" rel="stylesheet">

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
                    <a href="{{ route('import-form') }}" class="menu__item">Shop Import</a>
                    <a href="{{ route('shop-all') }}" class="menu__item">Show Review</a>
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

    <form class="form" action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="center">
            <div class="item">
                <div class="column">
                    <div class="title">ショップをインポートする</div>
                    <div class="item__all">
                        <div class="line">
                            <label class="item__name" for="csv_file">Select CSV file</label>
                            <input class="csv__input" type="file" id="csv_file" name="csv_file" required>
                        </div>
                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
                        @if (session('error'))
                        <div class="alert alert-danger">
                            {!! session('error') !!}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <button class="button" type="submit">Import</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.form');
            const csvInput = document.getElementById('csv_file');

            form.addEventListener('submit', function(e) {
                const file = csvInput.files[0];
                if (file) {
                    const fileName = file.name;
                    const fileExtension = fileName.split('.').pop().toLowerCase();

                    if (fileExtension !== 'csv') {
                        e.preventDefault();
                        alert('csv以外の拡張子はアップロードできません');
                    }
                }
            });
        });
    </script>
</body>

</html>
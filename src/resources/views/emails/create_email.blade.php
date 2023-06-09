<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/create-email.css') }}" rel="stylesheet">
    <title>Document</title>
</head>

<body>
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



    <form class="form" method="POST" action="{{ route('admins.send-email') }}">
        @csrf

        <div class="center">
            <div class="item">
                <div class="column">

                    <div class="title">メール一斉送信</div>

                    <div class="item__all">

                        <div class="line">
                            <label class="item__name" for="subject">Subject</label>
                            <input class="shop__name__text" type="text" name="subject" id="subject" value="{{ old('subject') }}" required>
                        </div>

                        @error('subject')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <div class="about">
                            <label class="about__name" for="message">Message</label>
                            <textarea name="message" id="message" required>{{ old('message') }}</textarea>
                        </div>

                        @error('message')
                        <p class="text-danger">{{ $message }}</p>
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

        <button class="button" type="submit">Send Email</button>
    </form>
</body>

</html>
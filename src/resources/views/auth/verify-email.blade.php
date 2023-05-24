<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
<div class="background">
    <x-jet-authentication-card>
        <x-slot name="logo">
        </x-slot>

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
                        <a href="{{ route('login') }}" class="menu__item">Mypage</a>
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
                </div>

                <div class="center">

                    <div class="box">

                        <h2 class="thanks">会員登録ありがとうございます</h2>

                    </div>

                </div>

                <div class="center">
                    {{ __('Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                </div>


                <div class="center">
                    @if (session('status') == 'verification-link-sent')
                    {{ __('A new verification link has been sent to the email address you provided in your profile settings.') }}
                    @endif
                </div>
            </div>

            <div class="mt-4 flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf

                    <div class="center">
                        <x-jet-button type="submit">
                            {{ __('Resend Verification Email') }}
                        </x-jet-button>
                    </div>
                </form>

                <div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <div class="center">
                            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 ml-2">
                                {{ __('Log Out') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-jet-authentication-card>
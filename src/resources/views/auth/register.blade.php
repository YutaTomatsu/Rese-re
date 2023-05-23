<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
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
    </div>

    <main class="main">

        <form class="form" method="POST" action="{{ route('register') }}">
            @csrf

            <div class="title">Register</div>

            <div class="center">
                <div>

                    <div class="line">
                        <img class="img" src="img/name.png" alt="Name">
                        <x-jet-input id="name" class="item" type="text" name="name" :value="old('name')"
                            required autofocus autocomplete="name" placeholder="Name" />
                    </div>

                    <div class="line">
                        <img class="img" src="img/email.png" alt="Email">
                        <x-jet-input id="email" class="item" type="email" name="email" :value="old('email')"
                            required placeholder="Email" />
                    </div>

                    <div class="line">
                        <img class="img" src="img/password.png" alt="Password">
                        <x-jet-input id="password" class="item" type="password" name="password" required
                            autocomplete="new-password" placeholder="Password" />
                    </div>

                    <div class="line">
                        <x-jet-input id="password_confirmation" class="item confirm" type="password"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="Password-Confirm" />
                    </div>

                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="mt-4">
                            <x-jet-label for="terms">
                                <div class="flex items-center">
                                    <x-jet-checkbox name="terms" id="terms" />

                                    <div class="ml-2">
                                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                            'terms_of_service' =>
                                                '<a target="_blank" href="' .
                                                route('terms.show') .
                                                '" class="underline text-sm text-gray-600 hover:text-gray-900">' .
                                                __('Terms of Service') .
                                                '</a>',
                                            'privacy_policy' =>
                                                '<a target="_blank" href="' .
                                                route('policy.show') .
                                                '" class="underline text-sm text-gray-600 hover:text-gray-900">' .
                                                __('Privacy Policy') .
                                                '</a>',
                                        ]) !!}
                                    </div>
                                </div>
                            </x-jet-label>
                        </div>
                    @endif

                    <div class="under-item">

                        <x-jet-button class="button">
                            {{ __('登録') }}
                        </x-jet-button>
                    </div>
                </div>
            </div>
        </form>
    </main>
    <div class="error">
        <x-jet-validation-errors class="" />
    </div>
</x-jet-authentication-card>

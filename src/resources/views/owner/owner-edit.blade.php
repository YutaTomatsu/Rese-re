<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/owner-edit.css') }}">
    <title>Document</title>
</head>



<body>

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


    <form class="form" method="POST" action="/owner/shop/{{ $shop->id }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="center">
            <div class="item">
                <div class="column">

                    <div class="title">ショップ情報</div>

                    <div class="item__all">

                        <div class="line">
                            <label class="item__name" for="name">店名</label>
                            <input class="shop__name__text" type="text" name="name" id="name"
                                value="{{ old('name', $shop->name) }}" required>

                        </div>

                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <div class="line">
                            <label class="item__name" for="area_id">エリア</label>
                            <select class="text" name="area_id" id="area_id" required>
                                <option value="">-- 選択してください --</option>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}"
                                        {{ old('area_id', $shop->area_id) == $area->id ? 'selected' : '' }}>
                                        {{ $area->area_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        @error('area_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <div class="line">
                            <label class="item__name" for="genre_id">ジャンル</label>
                            <select class="text" name="genre_id" id="genre_id" required>
                                <option value="">-- 選択してください --</option>
                                @foreach ($genres as $genre)
                                    <option value="{{ $genre->id }}"
                                        {{ old('genre_id', $shop->genre_id) == $genre->id ? 'selected' : '' }}>
                                        {{ $genre->genre_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        @error('genre_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <div class="line">
                            <label class="item__name" for="picture">画像</label>
                            <input class="picture" type="file" name="picture" id="picture" required>
                        </div>

                        @error('picture')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <div class="about">
                            <label class="about__name" for="about">店舗紹介文</label>
                            <textarea name="about" id="about" required>{{ old('about', $shop->about) }}</textarea>
                        </div>

                        @error('about')
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

        <button class="button" type="submit">更新する</button>

    </form>

</body>

</html>

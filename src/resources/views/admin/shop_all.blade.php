<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
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
            z-index: 1;
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

    <div class="card__row">
        @foreach ($shops as $shop)
        <div class="card">
            <img class="img" src="{{ $shop->picture }}" alt="{{ $shop->name }}">
            <div class="under__box">
                <div class="under__item">
                    <div class="shopname">{{ $shop->name }}</div>
                    <div class="hashtag">
                        <p class="tag">#{{ $shop->area_name }}</p>
                        <p class="tag">#{{ $shop->genre_name }}</p>
                    </div>
                    <div class="between">
                        <div class="shop-reviewsAvg" style="display: none;">{{ $shop->reviewsAvg }}</div>
                        <a class="admin__detail" href="{{ route('admin-review', ['id' => $shop->shop_id]) }}">口コミを見る</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <script>
        $(document).ready(function() {
            var shops = $('.card').toArray();
            $('#sort').change(function() {
                var sortingMethod = $(this).val();
                if (sortingMethod === 'random') {
                    shops.sort(function() {
                        return 0.5 - Math.random()
                    });
                } else if (sortingMethod === 'high') {
                    shops.sort(function(a, b) {
                        return parseFloat($(b).find('.shop-reviewsAvg').text()) - parseFloat($(a).find('.shop-reviewsAvg').text());
                    });
                } else if (sortingMethod === 'low') {
                    shops.sort(function(a, b) {
                        return parseFloat($(a).find('.shop-reviewsAvg').text()) - parseFloat($(b).find('.shop-reviewsAvg').text());
                    });
                }
                $('.card__row').empty();
                $.each(shops, function(i, item) {
                    $('.card__row').append(item);
                });
            });
        });
    </script>

    <script>
        $(document).on('click', '.toggle_img', function(e) {
            e.preventDefault();

            var shop_id = $(this).data('shopid');
            var user_id = $(this).data('userid');
            var img = $(this).attr('src');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            $.ajax({
                url: "{{ route('favorite') }}",
                method: "POST",
                data: {
                    shop_id: shop_id,
                    user_id: user_id
                },
            }).done(function(data) {
                if (data.status == 'success') {
                    if (img.includes('grayheart.svg')) {
                        $('.toggle_img[data-shopid="' + shop_id + '"]').attr('src',
                            "{{ asset('img/redheart.svg') }}");
                    } else {
                        $('.toggle_img[data-shopid="' + shop_id + '"]').attr('src',
                            "{{ asset('img/grayheart.svg') }}");
                    }
                    console.log(data.message);
                }
            }).fail(function() {
                console.log('Error: the request was not sent!!!.');
            });
        });
    </script>
</body>
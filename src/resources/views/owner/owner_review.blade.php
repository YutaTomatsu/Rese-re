<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/owner-review.css') }}">


    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">


</head>

<body class="antialiased">

    @if (Auth::check())
    <div class="header__left">
        <button class="icon" type="button"></button>
        <div class="under__line"></div>
        <div class="menu">
            <button class="close-button" type="button">X</button>
            <div class="menu__all">
                <a href="{{ 'owner' }}" class="menu__item">Home</a>
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
    </div>

    <div class="between">



        <div class="detail__left">



            <div class="detail">
                <div class="detail__top">
                    <h2 class="shopname">{{ $shop->name }}</h2>
                    <div class="rating__detail">
                        <div clss="rating__avg">
                            <p class="star-rating" data-rate="{{ round($reviews->avg('evaluate') * 2) / 2 }}"></p>
                        </div>
                        <p>{{ round($reviewsAvg, 1) }}/5</p>
                        <p>({{ $totalReviews }}件のレビュー)</p>
                    </div>
                </div>
                <img class="img" src="{{ $shop->picture }}" alt="{{ $shop->name }}">
                <div class="hashtag">
                    <p>#{{ $shop->area_name }}</p>
                    <p>#{{ $shop->genre_name }}</p>
                </div>
                <p class="about">
                <div class="about__title">紹介文</div>
                <div class="about__content">{{ $shop->about }}</div>
                </p>
            </div>


        </div>





        <div class="reserve__right">
            <div class="review">


                <h3>レビュー一覧</h3>

                @if (count($reviews) === 0)
                <p>まだレビューがありません</p>
                @else
                <div class="review__container">
                    @foreach ($reviews as $review)
                    <div class="review__item">
                        <p>投稿者: {{ $review->user->name }}</p>
                        <p class="star-rating" data-rate="{{ $review->evaluate }}"></p>
                        <p class="comment" data-full-comment="{{ $review->comment }}">{{ $review->comment }}
                        </p>
                        <p>投稿日時: {{ $review->created_at }}</p>
                        @php
                        $commentLength = mb_strlen($review->comment, 'UTF-8');
                        @endphp
                        @if ($commentLength > 20)
                        <button class="toggle-comment">全文を表示</button>
                        @endif
                    </div>
                    @endforeach
                </div>

                {{ $reviews->appends(array_merge($query_params, ['reviews_page' => $reviews->currentPage()]))->links('owner.reviews') }}
                @endif

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    $(document).ready(function() {
                        $('.review__container').css('overflow-y', 'scroll');
                        $('.review__container').css('max-height', '500px');

                        const truncateComment = (comment) => {
                            if (comment.length > 20) {
                                return comment.substr(0, 20) + '...';
                            }
                            return comment;
                        }

                        $('.comment').each(function() {
                            const $this = $(this);
                            const fullComment = $this.data('full-comment');
                            $this.text(truncateComment(fullComment));
                        });

                        $('.toggle-comment').on('click', function() {
                            const $this = $(this);
                            const $comment = $this.prevAll('.comment');
                            const fullComment = $comment.data('full-comment');
                            const isTruncated = $comment.text().includes("...");

                            if (isTruncated) {
                                $comment.text(fullComment);
                                $this.text('一部を表示');
                            } else {
                                $comment.text(truncateComment(fullComment));
                                $this.text('全文を表示');
                            }
                        });
                    });
                </script>

                <script>
                    const starRating = document.querySelector('.star-rating');
                    const rate = starRating.getAttribute('data-rate');
                    console.log(rate);
                </script>

            </div>
        </div>

    </div>


</body>
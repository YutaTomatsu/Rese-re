<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('css/admin_detail.css') }}">

    <title>Laravel</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">


</head>

<body class="antialiased">

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
            z-index: 100;
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

    <div class="content__box">
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

                    @if ($cources)
                    <div class="cource__title">コース紹介</div>
                    <div>1000円コース:1000円のコースです。</div>
                    <div>10000円コース:10000円のコースです。</div>
                    <div>100000円コース:100000円のコースです。</div>
                    @endif
                    </p>
                </div>
            </div>

            <div class="review">

                @if ($errors->has('message'))
                <div class="alert alert-danger">{{ $errors->first('message') }}</div>
                @endif

                <h3>レビュー一覧</h3>

                <form action="{{ route('admin-review-sort', ['id' => $shop->id]) }}" method="GET">
                    <label for="sort">並び替え:</label>
                    <select name="sort" id="sort">
                        <option value="high">評価が高い順</option>
                        <option value="low">評価が低い順</option>
                        <option value="new">投稿が新しい順</option>
                        <option value="old">投稿が古い順</option>
                    </select>
                    <button type="submit">適用</button>
                </form>

                <div class="review__content">
                    @if (count($reviews) === 0)
                    <p>まだレビューがありません</p>
                    @else
                    @foreach ($reviews as $review)
                    <div class="review__item" data-user="{{ (Auth::id() === $review->user_id) ? 'true' : 'false' }}">
                        <a href="#" class="review-delete" data-id="{{ $review->id }}">クチコミを削除</a>
                        <p>投稿者: {{ $review->user->name }}</p>
                        <p class="star-rating" data-rate="{{ $review->evaluate }}"></p>
                        <p class="comment" data-full-comment="{{ $review->comment }}">{{ $review->comment }}</p>
                        <p>投稿日時: {{ $review->created_at }}</p>
                        @php
                        $commentLength = mb_strlen($review->comment, 'UTF-8');
                        @endphp
                        @if ($commentLength > 20)
                        <button class="toggle-comment">全文を表示</button>
                        @endif
                        @if($review->image)
                        <img class="review__img" src="{{ asset('storage/'.$review->image) }}">
                        @endif
                    </div>
                    @endforeach

                    {{ $reviews->appends(array_merge($query_params, ['reviews_page' => $reviews->currentPage()]))->links('owner.reviews') }}
                    @endif
                </div>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script type="text/javascript">
                    document.addEventListener('DOMContentLoaded', function() {
                        var reviews = document.getElementsByClassName('review__item');
                        for (var i = 0; i < reviews.length; i++) {
                            var isUser = reviews[i].getAttribute('data-user') === 'true';
                            if (isUser) {
                                reviews[i].style.display = 'block';
                            }
                        }

                        var deleteLinks = document.querySelectorAll('.review-delete');
                        deleteLinks.forEach(function(link) {
                            link.addEventListener('click', function(e) {
                                e.preventDefault();
                                var reviewId = e.target.getAttribute('data-id');
                                var confirmed = confirm('本当に削除しますか？');
                                if (confirmed) {
                                    $.ajax({
                                        url: "{{ url('review-delete/') }}/" + reviewId,
                                        type: 'DELETE',
                                        data: {
                                            "_token": "{{ csrf_token() }}",
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                window.location.reload();
                                            } else {
                                                alert(response.error);
                                            }
                                        }
                                    });
                                }
                            });
                        });
                    });
                </script>
                <script>
                    $(document).ready(function() {
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
                            const isTruncated = $comment.text().length < fullComment.length;

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
            </div>
        </div>
    </div>
    </div>
    </div>
</body>
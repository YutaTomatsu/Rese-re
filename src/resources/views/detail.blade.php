<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">

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
                    <a href="{{ url('/dashboard') }}" class="menu__item">Home</a>
                    <form class="logout" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="menu__item">Logout</button>
                    </form>
                    <a href="{{ route('mypage') }}" class="menu__item">Mypage</a>
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

    <div class="content__box">

        <div class="between">



            <div class="detail__left">



                <div class="detail">
                    <div class="detail__top">
                        <h2 class="detail__title">{{ $shop->name }}</h2>
                        <div clss="rating__avg">
                            <p class="star-rating" data-rate="{{ round($reviews->avg('evaluate'), 1) }}"></p>
                        </div>


                        <div class="rating__detail">
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





            <div>



                <form class="form" action="reserve" method="post">
                    @csrf
                    <div class="center">
                        <div class="item">
                            <div class="column">
                                <div class="title">予約</div>
                                <input type="hidden" name="shop_id" value="{{ request()->query('id') }}">
                                <input class="date" type="date" name="date"
                                    value="{{ old('date', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}">
                                <select class="text" name="time" id="time-select">
                                    @php
                                        $selected_date = date('Y-m-d', strtotime(request('date', 'now')));
                                        $is_today = $selected_date == date('Y-m-d');
                                        $time_range = $is_today ? range(date('H') + 1, 23) : range(0, 23);
                                        if ($is_today && date('H') == 20) {
                                            array_push($time_range, 21);
                                        }
                                    @endphp
                                    @foreach ($time_range as $i)
                                        @for ($j = 0; $j < 60; $j += 15)
                                            @php
                                                $time = str_pad($i, 2, '0', STR_PAD_LEFT) . ':' . str_pad($j, 2, '0', STR_PAD_LEFT);
                                            @endphp


                                            <option value="{{ $time }}"
                                                {{ old('time') == $time ? 'selected' : '' }}
                                                {{ ($is_today && ($i > 21 || ($i === 21 && $j > 00))) || $i < 17 ? 'disabled' : '' }}>
                                                {{ $time }}
                                            </option>

                                            timeRange = timeRange.filter(time => {
                                            const hour = Math.floor(time / 4);
                                            const minute = (time % 4) * 15;
                                            return hour >= 17 && (hour < 21 || (hour===21 && minute <=00)); });
                                                @endfor
                                        @endforeach
                                </select>
                                <select class="text" name="number_of_people">
                                    @for ($i = 1; $i <= 20; $i++)
                                        <option value="{{ $i }}"
                                            {{ old('number_of_people') == $i ? 'selected' : '' }}>{{ $i }}人
                                        </option>
                                    @endfor
                                </select>

                                <div class="confirm">
                                    <div class="confirm__left">
                                        <div class="confirm__item">Shop</div>
                                        <div class="confirm__item">Date</div>
                                        <div class="confirm__item">Time</div>
                                        <div class="confirm__item">Number</div>
                                    </div>

                                    <div class="confirm__right">
                                        <div class="confirm__item">{{ $shop->name }}<div>
                                                <div class="confirm__item" id="dateDisplay"></div>
                                                <div class="confirm__item" id="timeDisplay"></div>
                                                <div class="confirm__item" id="numberOfPeopleDisplay"></div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                @if ($cources)
                                    <select class="text" name="cource" id="cource-select">
                                        <option value="">コースを選択</option>
                                        <option value="{{ $cources->cource_1 }}">{{ $cources->cource_1 }}</option>
                                        @if ($cources->cource_2)
                                            <option value="{{ $cources->cource_2 }}">{{ $cources->cource_2 }}
                                            </option>
                                        @endif
                                        @if ($cources->cource_3)
                                            <option value="{{ $cources->cource_3 }}">{{ $cources->cource_3 }}
                                            </option>
                                        @endif
                                    </select>
                                @endif

                                @if ($errors->has('time'))
                                    <div class="error">{{ $errors->first('time') }}</div>
                                @endif
                            </div>
                            <button class="button" type="submit">予約する</button>
                </form>

                <script>
                    document.querySelector('.date').addEventListener('change', function() {
                        const selectedDate = new Date(this.value);
                        const isToday = selectedDate.toDateString() === new Date().toDateString();
                        const timeSelect = document.querySelector('#time-select');
                        timeSelect.innerHTML = '';

                        let timeRange = [];
                        if (isToday) {
                            const currentHour = new Date().getHours();
                            timeRange = Array.from({
                                length: 24 * 4 - currentHour * 4 - parseInt(new Date().getMinutes() / 15) - 1
                            }, (_, i) => {
                                const hours = currentHour * 4;
                                const minutes = parseInt(new Date().getMinutes() / 15) + 1;
                                return i + hours + minutes;
                            });
                        } else {
                            timeRange = Array.from({
                                length: 24 * 4
                            }, (_, i) => i);
                        }

                        // 17:00から21:00までの時間帯に絞る
                        timeRange = timeRange.filter(time => {
                            const hour = Math.floor(time / 4);
                            const minute = (time % 4) * 15;
                            return hour >= 17 && (hour < 21 || (hour === 21 && minute <= 00));
                        });

                        timeRange.forEach(time => {
                            const hour = Math.floor(time / 4);
                            const minute = (time % 4) * 15;
                            const formattedHour = ('00' + hour).slice(-2);
                            const formattedMinute = ('00' + minute).slice(-2);
                            const option = document.createElement('option');
                            option.value = formattedHour + ':' + formattedMinute;
                            option.text = formattedHour + ':' + formattedMinute;
                            if (selectedDate.toDateString() === new Date().toDateString() && option.value < new Date()
                                .toLocaleTimeString([], {
                                    hour: '2-digit',
                                    minute: '2-digit'
                                })) {
                                option.disabled = true;
                            }
                            timeSelect.appendChild(option);
                        });
                    });
                </script>

                <script>
                    // フォームの要素を取得
                    const dateInput = document.querySelector('input[name="date"]');
                    const timeSelect = document.querySelector('select[name="time"]');
                    const numberOfPeopleSelect = document.querySelector('select[name="number_of_people"]');

                    // 値が変更された時に表示する関数
                    const displayValues = () => {
                        const date = dateInput.value;
                        const time = timeSelect.value;
                        const numberOfPeople = numberOfPeopleSelect.value;
                        console.log(`日付：${date} 時間：${time} 人数：${numberOfPeople}`);
                        document.getElementById("dateDisplay").textContent = date;
                        document.getElementById("timeDisplay").textContent = time;
                        document.getElementById("numberOfPeopleDisplay").textContent = numberOfPeople;
                    };

                    // 値が変更された時に displayValues 関数を呼び出すように設定
                    dateInput.addEventListener('change', displayValues);
                    timeSelect.addEventListener('change', displayValues);
                    numberOfPeopleSelect.addEventListener('change', displayValues);
                </script>

                <script>
                    const starRating = document.querySelector('.star-rating');
                    const rate = starRating.getAttribute('data-rate');
                    console.log(rate); // レートの平均値が表示される
                </script>
            </div>
        </div>
    </div>
    </div>

    <div class="review__center">
        <div class="review">

            <form class="review__write" action="{{ route('review') }}" method="get">
                @csrf
                <input type="hidden" name="shop_id" value="{{ request()->query('id') }}">
                <button class="review__button" type="submit">レビューを書く</button>
            </form>

            @if ($errors->has('message'))
                <div class="alert alert-danger">{{ $errors->first('message') }}</div>
            @endif


            <h3>レビュー一覧</h3>

            <form action="{{ route('review-sort', ['id' => $shop->id]) }}" method="GET">
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
                        <div class="review__item">
                            <p>投稿者: {{ $review->user->name }}</p>
                            <p class="star-rating" data-rate="{{ $review->evaluate }}"></p>
                            <p class="comment" data-full-comment="{{ $review->comment }}">{{ $review->comment }}</p>
                            <p>投稿日時: {{ $review->created_at }}</p>
                            @if (strlen($review->comment) > 20)
                                <button class="toggle-comment">全文を表示</button>
                            @endif
                        </div>
                    @endforeach

                    {{ $reviews->appends(['sort' => $sortOption])->links('owner.reviews') }}

                @endif
            </div>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

</body>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/reserve_edit.css') }}">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">


</head>

<body>

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

    <main class="main">

        <form class="form" action="{{ route('reservation.update', ['id' => $reservation->id]) }}" method="post">
            @csrf
            @method('PUT')
            <div class="center">
                <div class="item">
                    <div class="column">
                        <div class="title">予約</div>
                        <input class="date" type="date" name="date"
                            value="{{ old('date', $reservation->date) }}" min="{{ date('Y-m-d') }}">
                        <select class="text" name="time" id="time-select" value="{{ $reservation->time }}">
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
                                        {{ old('time', date('H:i', strtotime($reservation->time))) == $time ? 'selected' : '' }}
                                        {{ ($is_today && ($i > 21 || ($i === 21 && $j > 00))) || $i < 17 ? 'disabled' : '' }}>
                                        {{ $time }}
                                    </option>

                                    timeRange = timeRange.filter(time => {
                                    const hour = Math.floor(time / 4);
                                    const minute = (time % 4) * 15;
                                    return hour >= 17 && (hour < 21 || (hour===21 && minute <=00)); }); @endfor
                                @endforeach
                        </select>
                        <select class="text" name="number_of_people" value="{{ $reservation->number_of_people }}">
                            @for ($i = 1; $i <= 20; $i++)
                                <option value="{{ $i }}"
                                    {{ old('number_of_people', $reservation->number_of_people) == $i ? 'selected' : '' }}>
                                    {{ $i }}人</option>
                            @endfor
                        </select>

                        <div class="confirm">
                            <div class="confirm__left">
                                <div class="confirm__item">Date</div>
                                <div class="confirm__item">Time</div>
                                <div class="confirm__item">Number</div>
                            </div>

                            <div class="confirm__right">
                                <div class="confirm__item" id="dateDisplay"></div>
                                <div class="confirm__item" id="timeDisplay"></div>
                                <div class="confirm__item" id="numberOfPeopleDisplay"></div>
                            </div>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li class="error">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <button class="button" type="submit">更新する</button>
        </form>

    </main>

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

</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
    <title>Document</title>
</head>

<header class="header">
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

</header>

<body>




    <main class="main">

        <form class="form" id="card-form" action="{{ route('payment-store') }}" method="get">
            @csrf

            <div class="title">決済画面</div>

            <input type="hidden" name="shop_id" value="{{ $reserve->shop_id }}">
            <input type="hidden" name="date" value="{{ $reserve->date }}">
            <input type="hidden" name="time" value="{{ $reserve->time }}">
            <input type="hidden" name="number_of_people" value="{{ $reserve->number_of_people }}">
            <input type="hidden" name="cource" value="{{ $reserve->cource }}">

            <div class="center">

                <div class="column">

                    <div class="confirm__title">予約詳細</div>

                    <div class="confirm">
                        <div class="confirm__left">
                            <div class="confirm__item">Date</div>
                            <div class="confirm__item">Time</div>
                            <div class="confirm__item">Number</div>
                            <div class="confirm__item">Cource</div>
                        </div>

                        <div class="confirm__right">
                            <div class="confirm__item">{{ $reserve->date }}</div>
                            <div class="confirm__item">{{ $reserve->time }}</div>
                            <div class="confirm__item">{{ $reserve->number_of_people }}</div>
                            <div class="confirm__item">{{ $reserve->cource }}</div>
                        </div>
                    </div>

                    <div class="payment__title">カード情報</div>
                    <div class="payment">
                        <div class="line">
                            <label class="label" for="card_number">カード番号</label>
                            <div id="card-number" class="item"></div>
                        </div>

                        <div class="middle__box">
                            <div class="middle__line">
                                <label class="label" for="card_expiry">有効期限</label>
                                <div id="card-expiry" class="middle__item"></div>
                            </div>

                            <div class="middle__line">
                                <label class="label" for="card-cvc">セキュリティコード</label>
                                <div id="card-cvc" class="middle__item"></div>
                            </div>
                        </div>
                    </div>

                    <div id="card-errors" class="text-danger"></div>
                    <div class="under-item">
                        <button class="button">決済して予約を完了する</button>
                    </div>
                </div>
            </div>
        </form>
    </main>
    @if (session('flash_alert'))
    <div class="alert alert-danger">{{ session('flash_alert') }}</div>
    @elseif(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe_public_key = "{{ config('stripe.stripe_public_key') }}"
        const stripe = Stripe(stripe_public_key);
        const elements = stripe.elements();

        var cardNumber = elements.create('cardNumber');
        cardNumber.mount('#card-number');
        cardNumber.on('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        var cardExpiry = elements.create('cardExpiry');
        cardExpiry.mount('#card-expiry');
        cardExpiry.on('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        var cardCvc = elements.create('cardCvc');
        cardCvc.mount('#card-cvc');
        cardCvc.on('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        var form = document.getElementById('card-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            var errorElement = document.getElementById('card-errors');
            if (event.error) {
                errorElement.textContent = event.error.message;
            } else {
                errorElement.textContent = '';
            }

            stripe.createToken(cardNumber).then(function(result) {
                if (result.error) {
                    errorElement.textContent = result.error.message;
                } else {
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            var form = document.getElementById('card-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        }
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>

<header>
    <h2 class="header__left">Rese</h2>

    <div class="header__right">
        <form>
</form>
            

<form method="POST" action="{{ route('logout') }}" x-data x-on:submit="event.preventDefault(); $refs.form.submit();">
    @csrf

    <x-jet-responsive-nav-link href="{{ route('logout') }}">
        {{ __('Log Out') }}
    </x-jet-responsive-nav-link>
    <button type="submit" class="hidden" x-ref="form"></button>
</form>






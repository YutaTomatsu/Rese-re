@extends('layouts.common')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Past Reserves</div>
                    <div class="card__row">
                        @foreach ($pastReserves as $reserve)
                        <div class="card">
                            <img class="img" src="{{ $reserve->shop->picture }}" alt="{{ $reserve->shop->name }}">
                            <div class="under__item">
                                <div class="shopname">{{ $reserve->shop->name }}</div>
                                <div class="hashtag">
                                    <p class="tag">#{{ $reserve->area_name }}</p>
                                    <p class="tag">#{{ $reserve->genre_name }}</p>
                                </div>
                                <div class="between">
                                    <a class="detail" href="{{ route('detail', ['id' => $reserve->shop->shop_id]) }}">詳しく見る</a>
                                    <div>
                                        <a src=""></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="card-body">
                        @if ($pastReserves->count())
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pastReserves as $reserve)
                                <tr>
                                    <td>{{ $reserve->date }}</td>
                                    <td>{{ $reserve->time }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p>No past reserves found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
@endsection
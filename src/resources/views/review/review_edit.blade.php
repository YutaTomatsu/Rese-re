<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/review.css') }}">
    <title>Laravel</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

@extends('layouts.common')

@section('content')

<body class="antialiased">
    <form class="review__form" method="POST" action="{{ route('review.edit.store',['id' =>$review->id]) }}" enctype="multipart/form-data">
        @csrf
        <div class="between">
            <div class="detail__left">
                <div class="detail__left__box">
                    <div class="text">
                        クチコミを編集
                    </div>
                    <div class="card__row">
                        <div class="card">
                            <img class="img" src="{{ $shop->picture }}" alt="{{ $shop->name }}">
                            <div class="under__box">
                                <div class="under__item">
                                    <div class="shopname">{{ $shop->name }}</div>
                                    <div class="hashtag">
                                        <p class="tag">#{{ $shop->area_name }}</p>
                                        <p class="tag">#{{ $shop->genre_name }}</p>
                                    </div>
                                    <div class="card__between">
                                        <a class="detail" href="{{ route('detail', ['id' => $shop_id]) }}">詳しく見る</a>
                                        <div class="between__right">

                                            @if (Auth::check())
                                            @if (in_array($shop_id, $favorite_shops))
                                            <div class="heart">
                                                <img class="toggle_img" src="{{ asset('img/redheart.svg') }}" alt="heart" data-shopid="{{ $shop_id }}" data-userid="{{ Auth::id() }}">
                                            </div>
                                            @else
                                            <div class="heart">
                                                <img class="toggle_img" src="{{ asset('img/grayheart.svg') }}" alt="heart" data-shopid="{{ $shop_id }}" data-userid="{{ Auth::id() }}">
                                            </div>
                                            @endif
                                            @else
                                            <a href="{{ route('login') }}">
                                                <div class="heart">
                                                    <img src="img/grayheart.svg" alt="heart">
                                                </div>
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="review__right">
                <div class="review">
                    <div class="review__title">体験を評価して下さい</div>
                    <div class="review__body">
                        <div class="form-group row">
                            <input type="hidden" name="shop_id" value="{{ $shop_id }}">
                            <div class="rate-form">
                                <input id="star5" type="radio" name="evaluate" value="5">
                                <label for="star5">★</label>
                                <input id="star4" type="radio" name="evaluate" value="4">
                                <label for="star4">★</label>
                                <input id="star3" type="radio" name="evaluate" value="3">
                                <label for="star3">★</label>
                                <input id="star2" type="radio" name="evaluate" value="2">
                                <label for="star2">★</label>
                                <input id="star1" type="radio" name="evaluate" value="1">
                                <label for="star1">★</label>
                            </div>
                        </div>
                        <div class="comment__group">
                            <div for="comment" class="title">口コミを編集</div>
                            <div class="comment__box">
                                <textarea class="comment__text" name="comment" id="comment" class="form-control" required placeholder="{{$review->comment}}">{{ old('comment') }}</textarea>
                                <div class="max__text">0/400(最高文字数)</div>
                            </div>
                            @error('comment')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="img__group">
                            <div for="img" class="title">画像の追加</div>
                            <label for="image" class="img__box">
                                <div class="review__img" id="drop-zone">
                                    <div class="img__text">クリックして写真を追加</div>
                                    <div class="img__sub__text">またはドラッグアンドドロップ</div>
                                    <div class="filename" id="filename" style="display: none;"></div>
                                    <div id="file-error" style="display: none; color: red;"></div>
                                </div>
                            </label>
                            <input type="file" name="image" id="file-input" style="display: none;">
                        </div>

                        @if ($errors->any())
                        <div class="alert alert-danger mt-3">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @if (session('success'))
                        <div class="alert alert-success mt-3">
                            {{ session('success') }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <button class="review__button" type="submit" class="btn btn-primary">
            編集して投稿
        </button>
    </form>
</body>

<script>
    var originalFilename = "{{ basename($review->image) }}";
</script>
<script>
    $(document).ready(function() {
        if (originalFilename) {
            $("#filename").text(originalFilename).show();
            $(".img__text").hide();
            $(".img__sub__text").hide();
        }


        var dropZone = $('#drop-zone');
        var fileInput = $('#file-input');

        function updateUI(files) {
            if (files && files[0]) {

                $(".img__text").hide();
                $(".img__sub__text").hide();

                var filename = files[0].name;

                $("#filename").text(filename).show();
            }
        }

        dropZone.click(function() {
            fileInput.click();
        });

        fileInput.on('change', function(e) {
            updateUI(this.files);
        });

        dropZone.on('dragover', function(e) {
            e.preventDefault();
            dropZone.addClass('dragging');
        });

        dropZone.on('dragleave', function(e) {
            dropZone.removeClass('dragging');
        });

        dropZone.on('drop', function(e) {
            e.preventDefault();
            dropZone.removeClass('dragging');

            var files = e.originalEvent.dataTransfer.files;
            fileInput.prop('files', files);

            updateUI(files);
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
@endsection
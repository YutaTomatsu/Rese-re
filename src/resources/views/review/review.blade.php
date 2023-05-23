<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/review.css') }}">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">


</head>

@extends('layouts.common')

@section('content')

    <body class="antialiased">



        <div class="between">



            <div class="detail__left">



                <div class="detail">
                    <h2>{{ $shop->name }}</h2>
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

            <div class="review__right">



                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="review">
                                <div class="review__title">{{ __('レビューを書く') }}</div>

                                <div class="review__body">



                                    <form class="review__form" method="POST" action="{{ route('review.store') }}">
                                        @csrf

                                        <div class="form-group row">
                                            <label for="evaluate"
                                                class="col-md-4 col-form-label text-md-right">{{ __('評価') }}</label>

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

                                                @error('evaluate')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="comment__group">
                                            <label for="comment"
                                                class="col-md-4 col-form-label text-md-right">{{ __('コメント') }}</label>

                                            <div class="col-md-6">
                                                <textarea class="comment__text" name="comment" id="comment" class="form-control" required>{{ old('comment') }}</textarea>

                                                @error('comment')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <div class="button__group">
                                                <button class="review-button" type="submit" class="btn btn-primary">
                                                    {{ __('送信する') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>

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
                </div>
            </div>





        </div>


    </body>

@endsection

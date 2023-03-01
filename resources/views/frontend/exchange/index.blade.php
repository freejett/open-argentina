@extends('frontend._layout.master')

@section('metaTitle', 'Обменять доллары, рубли, евро, usd, euro, rub на песо в Буэнос Айресе')

@section('content')
    <!-- property area -->
    <div class="properties-area recent-property" style="background-color: #FFF;">

        <div class="page-head mb-5">
            <div class="container">
                <div class="row">
                    <div class="page-head-content">
                        <h1 class="page-title">Oбменные курсы</h1>
                        <p class="ml-4">Обмен долларов, евро, рублей, тенге на песо</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container padding-top-40">
            <div class="row">

                <div class="row row-feat">
                    <div class="blog-asside-right col-md-3">
                        @include('frontend.aparts._partial.ads_block')
                        @include('frontend.aparts._partial.similar_apartments')
                    </div>

                    <div class="blog-lst col-md-9">
                        @foreach ($exchanges as $chatId => $exchange)
                        <div class="col-sm-6 feat-list">
                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="">
                                        @if ($telegramChatsInfo[$chatId]->chat_photo)
                                            <a class="pull-left" href="{{ route('front.exchange.show', $telegramChatsInfo[$chatId]->username) }}">
                                                <img class="img-responsive img-circle telegram_avatar_min" src="{{ asset($avatarPath . $chatId .'/'. $telegramChatsInfo[$chatId]->chat_photo) }}" />
                                            </a>
                                        @endif
                                        <h4 class="" >
                                            <a href="{{ route('front.exchange.show', $telegramChatsInfo[$chatId]->username) }}">
                                                Канал {{ $telegramChatsInfo[$chatId]->title }}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="fqa11" class="panel-collapse  fqa-body">
                                        <div class="panel-body">
                                            <p>Обменные курсы:</p>
                                            <ul class="list-none">
                                                @foreach($exchange as $exchangeItem)
                                                    <li class="mr-3">
                                                        {!! $referenceExchangeDirections[$exchangeItem->exchange_direction_id]->directionString !!}:
                                                        <span><b>{{ $exchangeItem->rate }}</b></span>
                                                    </li>
                                                @endforeach
                                            </ul>

                                            <a class="btn btn-default" href="{{ route('front.exchange.show', $telegramChatsInfo[$chatId]->username) }}">
                                                Подробнее &rarr;
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

{{--                        <div class="col-sm-6 feat-list">--}}
{{--                            <div class="panel-group">--}}
{{--                                <div class="panel panel-default">--}}
{{--                                    <div class="panel-heading">--}}
{{--                                        <h4 class="panel-title fqa-title" data-toggle="" data-target="#fqa22" >--}}
{{--                                            Канал {{ $telegramChatsInfo[$exchange->chat_id]->title }}--}}
{{--                                        </h4>--}}
{{--                                    </div>--}}
{{--                                    <div id="fqa22" class="panel-collapse  fqa-body">--}}
{{--                                        <div class="panel-body">--}}
{{--                                            <p>По вопросам обмена: <a target="_blank" href="//t.me/{{ $telegramChatsInfo[$exchange->chat_id]->contact }}">--}}
{{--                                                    {{ $telegramChatsInfo[$exchange->chat_id]->contact }}--}}
{{--                                                </a></p>--}}
{{--                                            {!! nl2br($telegramChatsInfo[$exchange->chat_id]->about) !!}--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('frontend._layout.master')

@section('metaTitle', 'Обменять доллары, рубли, евро, usd, euro, rub на песо в Буэнос Айресе')

@section('content')
<!-- property area -->
<div class="properties-area recent-property" style="background-color: #FFF;">
    <div class="page-head mb-5">
        <div class="container">
            <div class="row">
                <div class="page-head-content">
                    <h1 class="page-title">Oбменные курсы канала</h1>
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
                    <div class="col-md-12 mb-5">
                        <a href="{{ url()->previous() }}" class="btn btn-default wow bounceInRight animated">Назад</a>
                    </div>

                    @if ($telegramChat->chat_photo)
                        <a class="pull-left" href="{{ route('front.exchange.show', $telegramChat->username) }}">
                            <img class="img-responsive img-circle telegram_avatar_min" src="{{ asset($avatarPath . $telegramChat->chat_id .'/'. $telegramChat->chat_photo) }}" />
                        </a>
                    @endif
                    <h2 >
                        Канал {{ $telegramChat->title }}
                    </h2>
                    <div class="col-sm-6 feat-list">
                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div id="fqa11" class="panel-collapse  fqa-body">
                                    <div class="panel-body">
                                        {!! nl2br($exchangeMsg->msg) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 feat-list">
                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div id="fqa22" class="panel-collapse  fqa-body">
                                    <div class="panel-body">
                                        <p>По вопросам обмена: <a target="_blank" href="//t.me/{{ $telegramChat->contact }}">
                                                {{ $telegramChat->contact }}
                                            </a></p>
                                        {!! nl2br($telegramChat->about) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

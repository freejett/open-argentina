@extends('frontend._layout.master')

@section('metaTitle', 'Open Argentina. Новости Аргентины и Латинской Америки')

@section('content')
<div class="content-area blog-page" style="background-color: #FCFCFC; padding-bottom: 55px;">
    <div class="page-head">
        <div class="container">
            <div class="row">
                <div class="page-head-content">
                    <h1 class="page-title">Новости Аргентины и Латинской Америки</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container padding-top-40">
        <div class="row">
            <div class="blog-asside-right col-md-3">
{{--                @include('frontend.aparts._partial.ads_block')--}}
                @include('frontend.aparts._partial.similar_apartments')
            </div>

            <div class="blog-lst col-md-9">
                {{ $news->onEachSide(2)->links() }}
                @foreach($news as $new)
                <section class="post">
                    <div class=" padding-b-50">
                        <a target="_blank" href="{{ $tgLinkBase . $new->channel->username .'/'. $new->msg_id }}">
                            <h3 class="1wow 1fadeInLeft 1animated">
                                {{ $new->title }}
                            </h3>
                        </a>
                        <div class="title-line wow fadeInRight animated"></div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            @if($new->channel->chat_photo)
                                <a target="_blank" href="{{ $tgLinkBase . $new->channel->username }}" style="float: left; margin: 0 15px 40px 0;">
                                    <img class="img-responsive img-circle" style="width: 50px;" src="{{ asset($avatarPath . $new->channel->chat_id .'/'. $new->channel->chat_photo) }}" />
                                </a>
                            @endif
                            <p class="author-category">
                                Канал <a target="_blank" href="{{ $tgLinkBase . $new->channel->username }}">
                                    {{ $new->channel->title }}
                                </a><br>
                                <i class="fa fa-calendar-o mr-3"></i>{{ \Illuminate\Support\Carbon::createFromTimestamp($new->date) }}<br>
                                <i class="fa fa-eye mr-3"></i>{{ $new->views }}<br>
                                <i class="fa fa-share-square-o mr-3"></i>{{ $new->forwards }}<br>
                            </p>
                        </div>
                    </div>

                    @if($new->cover)
                        <div class="image wow fadeInLeft animated">
                            <a href="{{ $tgLinkBase . $new->channel->username .'/'. $new->msg_id }}">
                                <img src="{{ asset('storage/aparts/'. $new->chat_id .'/'. $new->msg_id .'/'. $new->cover) }}" class="img-responsive" alt="{{ $new->title }}">
                            </a>
                        </div>
                    @endif

                    <p class="intro">
                        {!! nl2br($new->announcement) !!}
                    </p>
                    <p class="read-more">
                        <a target="_blank" href="{{ route('front.news.show', $new->id) }}" class="btn btn-default btn-border">Читать &rarr;</a>
                        <a target="_blank" href="{{ $tgLinkBase . $new->channel->username .'/'. $new->msg_id }}" class="btn btn-default btn-border">Читать полностью &rarr;</a>
                    </p>
                </section>
                @endforeach
                {{ $news->onEachSide(2)->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

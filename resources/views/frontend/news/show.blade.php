@extends('frontend._layout.master')

@section('metaTitle', 'Open Argentina. '. $news->title)

@section('content')
<div class="page-head">
    <div class="container">
        <div class="row">
            <div class="page-head-content">
                <h1 class="page-title">FAQ PAge</h1>
            </div>
        </div>
    </div>
</div>

<div class="content-area blog-page padding-top-40" style="background-color: #FCFCFC; padding-bottom: 55px;">
    <div class="container">
        <div class="row">
            <div class="blog-asside-right col-md-3">
                @include('frontend.aparts._partial.ads_block')
                @include('frontend.aparts._partial.similar_apartments')
            </div>

            <div class="blog-lst col-md-9">
                <p class="read-more">
                    <a href="{{ url()->previous() }}" class="btn btn-default btn-border">&larr; К списку новостей</a>
                </p>
                <section id="id-100" class="post single">
                    <div class="post-header single">
                        <div class="">
                            <h2 class="wow fadeInLeft animated">
                                {{ $news->title }}
                            </h2>
                            <div class="title-line wow fadeInRight animated"></div>
                        </div>
                        <div class="row wow fadeInRight animated">
                            <div class="col-sm-6">
                                @if($news->channel->chat_photo)
                                    <a target="_blank" href="{{ $tgLinkBase . $news->channel->username }}" style="float: left; margin: 0 15px 40px 0;">
                                        <img class="img-responsive img-circle" style="width: 50px;" src="{{ asset($avatarPath . $news->channel->chat_id .'/'. $news->channel->chat_photo) }}" />
                                    </a>
                                @endif
                                <p class="author-category">
                                    Канал <a target="_blank" href="{{ $tgLinkBase . $news->channel->username }}">
                                        {{ $news->channel->title }}
                                    </a>
                                </p>
                            </div>
                            <div class="col-sm-6 right" >
                                <p class="date-comments">
                                    <i class="fa fa-calendar-o mr-3"></i>{{ \Illuminate\Support\Carbon::createFromTimestamp($news->date) }}<br>
                                    <i class="fa fa-eye mr-3"></i>{{ $news->views }}<br>
                                    <i class="fa fa-share-square-o mr-3"></i>{{ $news->forwards }}<br>
                                </p>
                            </div>
                        </div>

                        @if($news->cover)
                            <div class="image wow fadeInLeft animated">
                                <a href="{{ $tgLinkBase . $news->channel->username .'/'. $news->msg_id }}">
                                    <img src="{{ asset('storage/aparts/'. $news->chat_id .'/'. $news->msg_id .'/'. $news->cover) }}" class="img-responsive" alt="{{ $news->title }}">
                                </a>
                            </div>
                        @endif

                        <div id="post-content" class="post-body single wow fadeInLeft animated mb-5">
                            {!! $news->body !!}
                        </div>

                        <p class="read-more mt-5">
                            <a target="_blank" href="{{ $tgLinkBase . $news->channel->username .'/'. $news->msg_id }}" class="btn btn-default btn-border">Читать полностью &rarr;</a>
                        </p>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection

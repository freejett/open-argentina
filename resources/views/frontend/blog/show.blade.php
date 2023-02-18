@extends('frontend._layout.master')

@section('metaTitle', 'Open Argentina. Блог. '. $post->title)

@section('content')
<div class="content-area blog-page" style="background-color: #FCFCFC; padding-bottom: 55px;">
    <div class="page-head">
        <div class="container">
            <div class="row">
                <div class="page-head-content">
                    <h1 class="page-title">{{ $post->title }}</h1>
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
                        <a href="{{ route('front.blog.index') }}" class="btn btn-default btn-border">&larr; К списку новостей</a>
                    </p>
                    <section id="id-100" class="post single">
                        <div class="post-header single">
                            <div class="col-sm-6">
                                <p class="author-category">
                                    Автор <a href="#">{{ $post->user->name }}</a>
                                </p>
                            </div>
                            <div class="col-sm-6 right" >
                                <p class="date-comments">
                                    <a href="#"><i class="fa fa-calendar-o mr-3"></i>{{ $post->published_at->toFormattedDateString() }}</a>
                                </p>
                            </div>
                            <img src="{{ $post->featured_image }}" class="img-responsive" alt="{{ $post->featured_image_caption }}" />
                        </div>

                        <div id="post-content" class="post-body single wow fadeInLeft animated">
                            {!! $post->body !!}
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

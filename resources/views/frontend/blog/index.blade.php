@extends('frontend._layout.master')

@section('metaTitle', 'Open Argentina. Блог')

@section('content')
<div class="content-area blog-page" style="background-color: #FCFCFC; padding-bottom: 55px;">
    <div class="page-head">
        <div class="container">
            <div class="row">
                <div class="page-head-content">
                    <h1 class="page-title">Блог</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container padding-top-40">
        <div class="row">
            <div class="blog-asside-right col-md-3">
                @include('frontend.aparts._partial.ads_block')
                @include('frontend.aparts._partial.similar_apartments')
            </div>

            <div class="blog-lst col-md-9">
                @foreach($posts as $post)
                <section class="post">
                    <div class="text-center padding-b-50">
                        <a href="{{ route('front.blog.show', $post->slug) }}">
                            <h2 class="wow fadeInLeft animated">
                                {{ $post->title }}
                            </h2>
                        </a>
                        <div class="title-line wow fadeInRight animated"></div>
                    </div>

                    <div class="row">
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
                    </div>
                    <div class="image wow fadeInLeft animated">
                        <a href="{{ route('front.blog.show', $post->slug) }}">
                            <img src="{{ $post->featured_image }}" class="img-responsive" alt="{{ $post->featured_image_caption }}">
                        </a>
                    </div>
                    <p class="intro">
                        {{ $post->summary }}
                    </p>
                    <p class="read-more">
                        <a href="{{ route('front.blog.show', $post->slug) }}" class="btn btn-default btn-border">Читать дальше &rarr;</a>
                    </p>
                </section>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

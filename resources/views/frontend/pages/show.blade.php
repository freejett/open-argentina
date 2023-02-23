@extends('frontend._layout.master')

@section('metaTitle', 'Обменять доллары, рубли, евро, usd, euro, rub на песо в Буэнос Айресе')

@section('content')
<div class="page-head">
    <div class="container">
        <div class="row">
            <div class="page-head-content">
                <h1 class="page-title">{{ $page->title }}</h1>
            </div>
        </div>
    </div>
</div>

<div class="content-area blog-page padding-top-40" style="background-color: #FCFCFC; padding-bottom: 55px;">
    <div class="container">
        <div class="row">
            <section class="blog-lst col-md-12 pl0">
                <section id="id-100" class="post single">

                    <div class="post-header single">
                        <div class="">
{{--                            <h2 class="wow fadeInLeft animated">FASHIN NOW 2016</h2>--}}
                            <div class="title-line wow fadeInRight animated"></div>
                        </div>
                        <div class="row wow fadeInRight animated">
{{--                            <div class="col-sm-6">--}}
{{--                                <p class="author-category">--}}
{{--                                    By <a href="#">John Snow</a>--}}
{{--                                    in <a href="blog.html">Webdesign</a>--}}
{{--                                </p>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-6 right" >--}}
{{--                                <p class="date-comments">--}}
{{--                                    <a href="single.html"><i class="fa fa-calendar-o"></i> June 20, 2013</a>--}}
{{--                                </p>--}}
{{--                            </div>--}}
                        </div>
                    </div>

                    <div id="post-content" class="post-body single wow fadeInLeft animated" style="font-weight: 500;">
                        {!! $page->content !!}
                    </div>
                </section>
            </section>
        </div>
    </div>
</div>
@endsection

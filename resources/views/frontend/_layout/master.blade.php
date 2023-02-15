<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('metaTitle')</title>
    <meta name="description" content="GARO is a real-estate template">
    <meta name="author" content="Kimarotec">
    <meta name="keyword" content="html5, css, bootstrap, property, real-estate theme , bootstrap template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,800' rel='stylesheet' type='text/css'>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="/assets/estate/assets/css/normalize.css">
    <link rel="stylesheet" href="/assets/estate/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/estate/assets/css/fontello.css">
    <link href="/assets/estate/assets/fonts/icon-7-stroke/css/pe-icon-7-stroke.css" rel="stylesheet">
    <link href="/assets/estate/assets/fonts/icon-7-stroke/css/helper.css" rel="stylesheet">
    <link href="/assets/estate/assets/css/animate.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="/assets/estate/assets/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="/assets/estate/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/estate/assets/css/icheck.min_all.css">
    <link rel="stylesheet" href="/assets/estate/assets/css/price-range.css">
    <link rel="stylesheet" href="/assets/estate/assets/css/owl.carousel.css">
    <link rel="stylesheet" href="/assets/estate/assets/css/owl.theme.css">
    <link rel="stylesheet" href="/assets/estate/assets/css/owl.transitions.css">
    <link rel="stylesheet" href="/assets/estate/assets/css/style.css?v=1">
    <link rel="stylesheet" href="/assets/estate/assets/css/responsive.css">
</head>
<body>

<div id="preloader">
    <div id="status">&nbsp;</div>
</div>
<!-- Body content -->
@include('frontend._partial.page_top')

@include('frontend._layout._partial.main_menu')

@yield('content')

<!-- Footer area-->
<div class="footer-area">

    <div class=" footer">
        <div class="container">
            <div class="row">

                <div class="col-md-4 col-sm-6 wow fadeInRight animated">
                    <div class="single-footer">
                        <h4>О нас</h4>
                        <div class="footer-title-line"></div>

                        <img src="/assets/estate/assets/img/logo_oa.png" alt="" class="wow pulse" data-wow-delay="1s">
                        <p>Open Argentina - проект, собирающий общедоступную информацию о жизни в Аргентине и помогающий людям адаптироваться в новой стране</p>
{{--                        <ul class="footer-adress">--}}
{{--                            <li><i class="pe-7s-map-marker strong"> </i> 9089 your adress her</li>--}}
{{--                            <li><i class="pe-7s-mail strong"> </i> email@yourcompany.com</li>--}}
{{--                            <li><i class="pe-7s-call strong"> </i> +1 908 967 5906</li>--}}
{{--                        </ul>--}}
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 wow fadeInRight animated">
                    <div class="single-footer">
                        <h4>Правовая информация</h4>
                        <div class="footer-title-line"></div>
                        <ul class="footer-menu">
                            <li><a href="{{ route('front.page.show', 'privacy') }}">Политика конфиденциальности</a>  </li>
                            <li><a href="{{ route('front.page.show', 'disclaimer') }}">Отказ от ответственности</a>  </li>
                            <li><a href="{{ route('front.page.show', 'terms') }}">Пользовательское соглашение</a>  </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 wow fadeInRight animated">
                    <div class="single-footer">
                        <h4>Последние новости</h4>
                        <div class="footer-title-line"></div>
                        @widget('recentPosts')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-copy text-center">
        <div class="container">
            <div class="row">
                <div class="pull-left">
                    Дизайн сайта - <span> (C) <a href="http://www.KimaroTec.com">KimaroTheme</a>, 2016</span>
                    Логотип - <span> <a href="https://www.vecteezy.com/free-vector/home-logo"> Vecteezy</a> </span>
                </div>
                <div class="bottom-menu pull-right">
                    <ul>
                        @foreach($menuItems as $link => $title )
                            <li>
                                <a  class="wow fadeInUp animated" data-wow-delay="{{ $loop->index * 1.15 / 10 }}s" href="{!! $link !!}">
                                    {!! $title !!}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="/assets/estate/assets/js/modernizr-2.6.2.min.js"></script>

<script src="/assets/estate/assets/js/jquery-1.10.2.min.js"></script>
<script src="/assets/estate/bootstrap/js/bootstrap.min.js"></script>
<script src="/assets/estate/assets/js/bootstrap-select.min.js"></script>
<script src="/assets/estate/assets/js/bootstrap-hover-dropdown.js"></script>

<script src="/assets/estate/assets/js/easypiechart.min.js"></script>
<script src="/assets/estate/assets/js/jquery.easypiechart.min.js"></script>

<script src="/assets/estate/assets/js/owl.carousel.min.js"></script>
<script src="/assets/estate/assets/js/wow.js"></script>

<script src="/assets/estate/assets/js/icheck.min.js"></script>
<script src="/assets/estate/assets/js/price-range.js"></script>

<script src="/assets/estate/assets/js/main.js"></script>

@yield('script')

</body>
</html>

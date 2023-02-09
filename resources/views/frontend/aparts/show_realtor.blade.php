@extends('frontend._layout.master')

@section('metaTitle', 'Найти квартиру, дом в Буэнос-Айресе. ')

@section('content')
<!-- page header -->
<div class="page-head">
    <div class="container">
        <div class="row">
            <div class="page-head-content">
                <h1 class="page-title">Помощь в подборе квартиры: {{ $realtor->name }}</h1>
            </div>
        </div>
    </div>
</div>
<!-- End page header -->

<!-- property area -->
<div class="content-area single-property" style="background-color: #FCFCFC;">
    <div class="container padding-top-40">
        <a href="{{ url()->previous() }}" class="navbar-btn nav-button wow bounceInRight animated">Назад</a>
    </div>
    <div class="container">
        <h3>{{ $realtor->name }}</h3>
        {!! nl2br($realtor->msg) !!}
    </div>
</div>
@endsection
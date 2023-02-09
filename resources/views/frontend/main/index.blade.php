@extends('frontend._layout.master')

@section('metaTitle', 'Главная')

@section('content')

    <div class="slider-area">
        @include('frontend._partial.map')
    </div>

    <div class="home-lager-shearch" style="background-color: rgb(252, 252, 252); padding-top: 25px; margin-top: -125px;">
        <div class="container">
            <div class="col-md-12 large-search">
                <div class="search-form wow pulse">
                    <form method="GET" action="{{ route('front.aparts.index') }}" class=" form-inline">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label for="price-range">Количество комнат:</label>
                                <select name="number_of_rooms" id="lunchBegins" class="selectpicker" data-live-search="true" data-live-search-style="begins" title="Количество комнат">
                                    <option value="0">Любое</option>
                                    <option value="d">Дуплекс</option>
                                    <option value="1">Студия</option>
                                    <option value="2">2 комнаты</option>
                                    <option value="3">3 комнаты</option>
                                    <option value="4">4 комнаты</option>
                                    <option value="5">5 комнат</option>\
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label for="price-range">Стоимость (USD):</label>
                                <input name="price" type="text" class="span2" value="" data-slider-min="0"
                                       data-slider-max="5000" data-slider-step="50"
                                       data-slider-value="[300,2000]" id="price-range" ><br />
                                <b class="pull-left color">0 USD</b>
                                <b class="pull-right color">5000 USD</b>
                            </div>
                            <div class="search-row">
                                <div class="col-sm-6">
                                    <div class="checkbox">
                                        <label>
                                            <input name="kids_allowed" type="checkbox"> можно с детьми
                                        </label>
                                    </div>

                                    <div class="checkbox">
                                        <label>
                                            <input name="pets_allowed" type="checkbox"> можно с животными
                                        </label>
                                    </div>
                                </div>
                                <!-- End of  -->
                            </div>
                        </div>
                        <div class="center">
                            <input type="submit" value="" class="btn btn-default btn-lg-sheach">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('frontend._partial.widgets.exchange_rate')



    @include('frontend._partial.widgets.stat_block')
@endsection

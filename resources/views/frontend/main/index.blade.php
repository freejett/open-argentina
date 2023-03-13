@extends('frontend._layout.master')

@section('metaTitle', 'Главная')

@section('content')

    <div class="slider-area">
        @include('frontend._partial.map')
    </div>

    <div class="home-lager-shearch" style="background-color: rgb(252, 252, 252); padding-top: 25px; margin-top: 0;">
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
                                <div class="col-md-6">
                                    <input type="submit" value="Искать" class="btn btn-default">
                                </div>
                                <!-- End of  -->
                            </div>
                        </div>
                        <div class="center">
{{--                            <input type="submit" value="" class="btn btn-default btn-lg-sheach">--}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('frontend._partial.widgets.exchange_rate')

    <!-- Count area -->
    <div class="count-area">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1 col-sm-12 text-center page-title mt-0">
                    <!-- /.feature title -->
                    <h2 class="mb-0">Немного о проекте</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-xs-12 percent-blocks m-main pt-5" data-waypoint-scroll="true">
                    <div class="row">
                        <p>Проект Open Argentina создан с целью собрать в одном месте необходимую информацию о жизни в Аргентине и, в частности, в Буэнос-Айресе. Идея возникла после переезда в Аргентину и попытке как-то сориентироваться в новых условиях.</p>
                        <p>На страницах проекта можно найти следующую информацию:</p>
                        <ul>
                            <li>найти квартиру на длительный срок</li>
                            <li>заказать обмен валют валют</li>
                            <li>дайджест новостей о Буэнос-Айресе, Аргентине и Латинской Америке</li>
                            <li>заказать доставку еды</li>
                            <li>найти тренера, врача, электрика и т.д.</li>
                            <li>найти клубам и спортивным секицям</li>
                            <li>и многое другое</li>
                        </ul>
                        <p>Если у вас будут какие-то идеи, пожелания - пишите нам, попробуем сделать этот проект лучше :)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('frontend._partial.widgets.stat_block')
@endsection

<!-- Count area -->
<div class="count-area">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 col-sm-12 text-center page-title">
                <!-- /.feature title -->
                <h2 class="mb-5">
                    <a href="{{ route('front.exchange.index') }}">
                        Обменные курсы
                    </a>
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-xs-12 1percent-blocks m-main" data-waypoint-scroll="true">
                <div class="row">
                    @foreach($exchange as $exchangeItem)
                        <div class="col-sm-3 col-xs-6 mb-5">
                            <div class="count-item b1" >
                                <div class="chart">
                                    <h4>{!! $referenceExchangeDirections[$exchangeItem->exchange_direction_id]->directionString !!}</h4>
                                    <h2 class="percent">{{ $exchangeItem->rate }}</h2>
                                </div>
                            </div>
                        </div>
                    @endforeach
{{--                    <div class="col-sm-3 col-xs-6">--}}
{{--                        <div class="count-item">--}}
{{--                            <div class="chart">--}}
{{--                                <h4>USD &rarr; ARS</h4>--}}
{{--                                <h2 class="percent">369</h2>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>

                <div class="text-right">
                    <a href="{{ route('front.exchange.index') }}" class="btn btn-default">Подробнее</a>
                </div>
            </div>
        </div>
    </div>
</div>

@extends('frontend._layout.master')

@section('metaTitle', 'Обменять доллары, рубли, евро, usd, euro, rub на песо в Буэнос Айресе')

@section('content')
    <!-- property area -->
    <div class="properties-area recent-property" style="background-color: #FFF;">

        <div class="page-head mb-5">
            <div class="container">
                <div class="row">
                    <div class="page-head-content">
                        <h1 class="page-title">Oбменные курсы</h1>
                        <p class="ml-4">Обмен долларов, евро, рублей, тенге на песо</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-5">
            <div class="row">

                @foreach ($exchanges as $exchange)
                <div class="row row-feat">
                    <div class="col-md-12">
                        <div class="col-sm-6 feat-list">
                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title fqa-title" >
                                            Курсы канала {{ $telegramChatsInfo[$exchange->chat_id]->title }}
                                        </h4>
                                    </div>
                                    <div id="fqa11" class="panel-collapse  fqa-body">
                                        <div class="panel-body">
                                            {!! nl2br($exchange->msg) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 feat-list">
                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title fqa-title" data-toggle="" data-target="#fqa22" >
                                            Канал {{ $telegramChatsInfo[$exchange->chat_id]->title }}
                                        </h4>
                                    </div>
                                    <div id="fqa22" class="panel-collapse  fqa-body">
                                        <div class="panel-body">
                                            <p>По вопросам обмена: <a target="_blank" href="//t.me/{{ $telegramChatsInfo[$exchange->chat_id]->contact }}">
                                                    {{ $telegramChatsInfo[$exchange->chat_id]->contact }}
                                                </a></p>
                                            {!! nl2br($telegramChatsInfo[$exchange->chat_id]->about) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection

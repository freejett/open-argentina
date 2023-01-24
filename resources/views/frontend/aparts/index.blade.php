@extends('frontend._layout.master')

@section('metaTitle', 'Найти квартиру в Буэнос-Айресе')

@section('content')
<!-- property area -->
<div class="properties-area recent-property" style="background-color: #FFF;">
    @include('frontend._partial.map')

    <div class="container">
        <div class="row">

            <div class="col-md-3 p0 padding-top-40">
                <div class="blog-asside-right pr0">
                    @include('frontend._partial.sidebar_search')
                </div>
            </div>

            <div class="col-md-9  pr0 padding-top-40 properties-page">
                <div class="col-md-12 clear">
                    @include('frontend._partial.page_view_settings')
                </div>

                <div class="col-md-12 clear">
                    <div id="list-type" class="proerty-th m-4">
                        @foreach($apartments as $i => $apartment)
                            @include('frontend.aparts._partial.apart_preview_card')

                            @if ($i % 3 == 2)
                                <div class="clear"></div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

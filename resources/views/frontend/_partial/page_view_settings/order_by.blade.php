<ul class="sort-by-list">
{{--    <li class="active">--}}
{{--        <a href="javascript:void(0);" class="order_by_date" data-orderby="property_date" data-order="ASC">--}}
{{--            По дате <i class="fa fa-sort-amount-asc"></i> <i class="fa fa-sort-amount-desc"></i>--}}
{{--        </a>--}}
{{--    </li>--}}
    <li class="">
        @if ($request->query('order') == 'price_desc')
            <a href="{{ $request->fullUrlWithoutQuery(['order']) }}&order=price_asc" class="order_by_price" data-orderby="property_price" data-order="ASC">
                По цене
                <i class="fa fa-sort-amount-desc"></i>
            </a>
        @else
            <a href="{{ $request->fullUrlWithoutQuery(['order']) }}&order=price_desc" class="order_by_price" data-orderby="property_price" data-order="DESC">
                По цене
                <i class="fa fa-sort-amount-asc"></i>
            </a>
        @endif
    </li>
</ul>

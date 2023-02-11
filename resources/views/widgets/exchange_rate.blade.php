<ul class="list-inline">
    <li>💵 Курс на сегодня:</li>
    @foreach($exchange as $exchangeItem)
        <li class="mr-3">
            {!! $referenceExchangeDirections[$exchangeItem->exchange_direction_id]->directionString !!}:
            <span><b>{{ $exchangeItem->rate }}</b></span>
        </li>
    @endforeach
</ul>
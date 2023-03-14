<ul class="list-inline">
    <li>💵 Курс на сегодня:</li>
    @if (count($exchange))
        @foreach($exchange as $exchangeItem)
            <li class="mr-3">
                {!! $referenceExchangeDirections[$exchangeItem->exchange_direction_id]->directionString !!}:
                <span><b>{{ $exchangeItem->max }}</b></span>
            </li>
        @endforeach
    @else
        <li class="mr-3"><span class="font-light">Информация из телеграм каналов пока не получена</span></li>
    @endif
</ul>

<div class="col-sm-6 col-md-4 p0">
    <div class="box-two proerty-item">
        <div class="item-thumb">
            <a href="{{ route('front.aparts.show', $apartment->id) }}" target="_blank">
                @if ($apartment->photo)
                    <img src="{{ asset('storage/aparts/'. $apartment->chat_id .'/'. $apartment->msg_id .'/'. $apartment->photo) }}" />
                @else
                    <img src="/assets/estate/assets/img/logo.png">
                @endif
            </a>
        </div>

        <div class="item-entry overflow">
            <h5><a href="{{ route('front.aparts.show', $apartment->id) }}" target="_blank">{{ $apartment->title }}</a></h5>
            <div class="dot-hr"></div>
            <span class="pull-left">📍{{ $apartment->address }} </span>
            <span class="proerty-price pull-right"> $ {{ (int) $apartment->price }}</span>
            <p style="display: none;">
                {{ $apartment->full_address }}<br />
                {{ $apartment->full_price }}
            </p>
            <div class="property-icon">
                <img src="/assets/estate/assets/img/icon/bed.png">(5)|
                <img src="/assets/estate/assets/img/icon/shawer.png">(2)|
                <img src="/assets/estate/assets/img/icon/cars.png">(1)
            </div>
        </div>
    </div>
</div>

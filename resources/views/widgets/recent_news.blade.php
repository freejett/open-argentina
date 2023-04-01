@foreach($news as $new)
    <div class="item">
        <div class="client-text">
            <i class="fa fa-calendar-o mr-3"></i>{{ \Illuminate\Support\Carbon::createFromTimestamp($new->date) }}
            <hr style="margin: 15px 0;">
            <p>{!! nl2br($new->announcement) !!}</p>
            <a target="_blank" href="{{ $tgLinkBase . $new->channel->username .'/'. $new->msg_id }}" class="">Читать полностью &rarr;</a>
            <br>
            Канал <a target="_blank" href="{{ $tgLinkBase . $new->channel->username }}">
                {{ $new->channel->title }}
            </a>
        </div>
        <div class="client-face wow fadeInRight" data-wow-delay=".9s">
            <a target="_blank" href="{{ $tgLinkBase . $new->channel->username .'/'. $new->msg_id }}">
                <img alt="{{ $new->channel->title }}" class="img-responsive img-circle" style="width: 50px;" src="{{ asset($avatarPath . $new->channel->chat_id .'/'. $new->channel->chat_photo) }}" />
            </a>
        </div>
    </div>
@endforeach

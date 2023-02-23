<div class="dealer-widget">
    <div class="dealer-content">
        <div class="inner-wrapper">

            <div class="clear">
                <div class="col-xs-4 col-sm-4 dealer-face">
                    <a href="{{ route('front.aparts.realtor', 1) }}">
                        <img src="/assets/estate/assets/img/client-face1.png" class="img-circle">
                    </a>
                </div>
                <div class="col-xs-8 col-sm-8 ">
                    <h3 class="dealer-name">
                        <a href="{{ route('front.aparts.realtor', 1) }}">
                            {{ $realtor->name }}
                        </a> <br>
                        <span>Помощь в подборе жилья</span>
                    </h3>
{{--                    <div class="dealer-social-media">--}}
{{--                        <a class="twitter" target="_blank" href="">--}}
{{--                            <i class="fa fa-twitter"></i>--}}
{{--                        </a>--}}
{{--                        <a class="facebook" target="_blank" href="">--}}
{{--                            <i class="fa fa-facebook"></i>--}}
{{--                        </a>--}}
{{--                        <a class="gplus" target="_blank" href="">--}}
{{--                            <i class="fa fa-google-plus"></i>--}}
{{--                        </a>--}}
{{--                        <a class="linkedin" target="_blank" href="">--}}
{{--                            <i class="fa fa-linkedin"></i>--}}
{{--                        </a>--}}
{{--                        <a class="instagram" target="_blank" href="">--}}
{{--                            <i class="fa fa-instagram"></i>--}}
{{--                        </a>--}}
{{--                    </div>--}}
                </div>
            </div>

            <div class="clear">
                <ul class="dealer-contacts">
                    @if ($realtor->telegram)
                    <li>
                        <i class="pe-7s-telegram" aria-hidden="true"></i>
                        {{ $realtor->telegram }}
                    </li>
                    @endif
                    @if ($realtor->whatsapp)
                        <li>
                            <i class="pe-7s-whatsapp" aria-hidden="true"></i>
                            {{ $realtor->whatsapp }}
                        </li>
                    @endif
{{--                    <li><i class="pe-7s-map-marker strong"> </i> 9089 your adress her</li>--}}
{{--                    <li><i class="pe-7s-mail strong"> </i> email@yourcompany.com</li>--}}
{{--                    <li><i class="pe-7s-call strong"> </i> +1 908 967 5906</li>--}}
                </ul>
                <div>
                    {!! nl2br($realtor->msg_preview) !!}
                </div>
            </div>

        </div>
    </div>
</div>

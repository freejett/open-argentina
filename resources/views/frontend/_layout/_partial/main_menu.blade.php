<nav class="navbar navbar-default ">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigation">
                <span class="sr-only">Переключить навигацию</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">
                <img src="/assets/estate/assets/img/logo.png" alt="">
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse yamm" id="navigation">
            <div class="button navbar-right">
{{--                <button class="navbar-btn nav-button wow bounceInRight login" onclick=" window.open('register.html')"--}}
{{--                        data-wow-delay=".45s">Войти--}}
{{--                </button>--}}
                {{--                <button class="navbar-btn nav-button wow fadeInRight" onclick=" window.open('submit-property.html')" data-wow-delay="0.48s">Submit</button>--}}
            </div>
            <ul class="main-nav nav navbar-nav 1navbar-right mar-l-20">
                @foreach($menuItems as $link => $title )
                    <li class="wow fadeInDown" data-wow-delay="{{ $loop->index * 1.15 / 10 }}s">
                        <a @if(str_starts_with(url()->full(), $link)) class="active" @endif href="{!! $link !!}">
                            {!! $title !!}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<!-- End of nav bar -->

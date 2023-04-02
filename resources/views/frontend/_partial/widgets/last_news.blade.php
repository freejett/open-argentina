<!--Последние новости -->
<div class="testimonial-area recent-property" style="background-color: #FCFCFC; padding-bottom: 15px;">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 col-sm-12 text-center page-title">
                <!-- /.feature title -->
                <h2><a href="{{ route('front.news.index') }}">Свежие новости</a></h2>
            </div>
        </div>

        <div class="row">
            <div class="row testimonial">
                <div class="col-md-12">
                    <div id="testimonial-slider">
                        @widget('recentNews')
                    </div>
                    <div class="text-right">
                        <a class="btn btn-default" href="{{ route('front.news.index') }}">Все новости</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

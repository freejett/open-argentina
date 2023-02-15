<ul class="footer-blog">
    @foreach($lastPosts as $post)
        <li>
            <div class="col-md-3 col-sm-4 col-xs-4 blg-thumb p0">
                <a href="single.html">
                    <img src="{{ $post->featured_image }}" alt="{{ $post->featured_image_caption }}">
                </a>
                <span class="blg-date">{{ $post->published_at }}</span>
            </div>
            <div class="col-md-9  col-sm-8 col-xs-8  blg-entry">
                <h6> <a href="single.html">{{ $post->title }}</a></h6>
                <p style="line-height: 17px; padding: 8px 2px;">{{ $post->summary }}</p>
            </div>
        </li>
    @endforeach
</ul>

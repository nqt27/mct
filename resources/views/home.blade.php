@include('layout-header')

<!-- QUẢNG CÁO TEST (KHÔNG TÍNH TIỀN, CHỈ DÙNG ĐỂ XEM GIAO DIỆN) -->
{{-- <div style="margin: 20px 0; text-align: center;">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9584109307122135"
        crossorigin="anonymous"></script>
    <!-- quảng cáo -->
    <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-9584109307122135" data-ad-slot="5221647872"
        data-ad-format="auto" data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div> --}}


<div class="container" style="margin-bottom: 30px;">
    <section class="snake-slider">
        <div class="carousel-container">
            <div class="carousel">
                @foreach ($slide as $s)
                    <div class="card" data-flipped="false">
                        <div class="front"
                            style="background-image: url('{{ asset('uploads/images/' . $s->filename) }}');"></div>

                    </div>
                @endforeach

            </div>
            <div class="carousel-indicator"></div>
        </div>


    </section>
    <section class="snake-content">
        <div class="content-left-item">
            <div class="content-left-item-header">
                <h2 class="block-title">

                    <span class="block-title-inner">Mới nhất</span>
                    <a title="Mới nhất" href="{{ route('allTMa.index') }}">
                        <div class="text_container">
                            <p>XEM THÊM <i class="fa-solid fa-angles-right"></i></p>
                            <p>XEM THÊM <i class="fa-solid fa-angles-right"></i></p>
                        </div>
                    </a>
                </h2>
            </div>
            <!-- <div id="bokeh-background"></div> -->
            <div class="slider-container">
                <div class="slider-wrapper">
                    <div class="slider">
                        @foreach ($new_audio->chunk(4) as $index => $group)
                            <div class="slide-group {{ $loop->first ? 'active' : '' }}">
                                @foreach ($group as $p)
                                    <div class="card" data-tilt>
                                        <a href="{{ route('detail', $p->slug) }}">
                                            <img src="{{ asset('uploads/images/' . $p->image) }}"
                                                title="{{ $p->ten }}" alt="{{ $p->ten }}">
                                            <h3>{{ $p->ten }}</h3>
                                            <p><i class="fa-solid fa-eye"></i>Lượt xem: 30</p>
                                            <p><i class="fa-solid fa-calendar-days"></i>Phát hành: 1-1-2025</p>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach




                    </div>
                </div>

                <button class="nav-btn prev-btn">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="nav-btn next-btn">
                    <i class="fas fa-chevron-right"></i>
                </button>

                <div class="slider-dots"></div>
            </div>

        </div>
        <div class="content-left-item">
            <div class="content-left-item-header">
                <h2 class="block-title">

                    <span class="block-title-inner">Nghe nhiều nhất</span>
                    <a title="Nghe nhiều nhất" href="#">
                        <div class="text_container">
                            <p>XEM THÊM <i class="fa-solid fa-angles-right"></i></p>
                            <p>XEM THÊM <i class="fa-solid fa-angles-right"></i></p>
                        </div>
                    </a>
                </h2>
            </div>
            <!-- <div id="bokeh-background"></div> -->
            <div class="slider-container">
                <div class="slider-wrapper">
                    <div class="slider">
                        @foreach ($new_audio->chunk(4) as $index => $group)
                            <div class="slide-group {{ $loop->first ? 'active' : '' }}">
                                @foreach ($group as $p)
                                    <div class="card" data-tilt>
                                        <a href="{{ route('detail', $p->slug) }}">
                                            <img src="{{ asset('uploads/images/' . $p->image) }}"
                                                title="{{ $p->ten }}" alt="{{ $p->ten }}">
                                            <h3>{{ $p->ten }}</h3>
                                            <p><i class="fa-solid fa-eye"></i>Lượt xem: 30</p>
                                            <p><i class="fa-solid fa-calendar-days"></i>Phát hành: 1-1-2025</p>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach


                    </div>
                </div>

                <button class="nav-btn prev-btn">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="nav-btn next-btn">
                    <i class="fas fa-chevron-right"></i>
                </button>

                <div class="slider-dots"></div>
            </div>

        </div>
        <div class="content-left-item post">
            <div class="content-left-item-header">
                <h2 class="block-title">
                    <a title="Bài viết được quan tâm" href="#">
                        <span class="block-title-inner">Bài viết được quan tâm</span>
                    </a>
                </h2>
            </div>
            <h3>Blog MCT Media – Những Kiến Thức, Kinh Nghiệm Hay</h3>
            <div class="content-left-item-content">
                @foreach ($blog as $n)
                    <div class="card">
                        <img src="{{ asset('images/' . $n->image) }}" class="card-img-top" alt="{{ $n->title }}">
                        <div class="card-body">
                            <div class="noidung-dichvu">
                                <h5 class="card-title">{{ $n->tieude }}</h5>
                                <p class="card-text">{!! Str::limit($n->noidung, 100) !!}</p>
                            </div>
                            <a href="{{ route('blogdetail', $n->slug) }}" class="btn btn-primary vertical-button">Xem
                                chi
                                tiết</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <h3>MCT Media – Giải Pháp Truyền Thông Cho Mọi Người</h3>
            <div class="info">
                @foreach ($dichvu as $dv)
                    <figure class="snip1156">
                        <img src="{{ asset('images/' . $dv->image) }}" alt="{{ $dv->name }}" />
                        <figcaption>
                            <div>
                                <h2>{{ $dv->tieude }} </h2>
                            </div>
                        </figcaption>
                        <a href="#"></a>
                    </figure>
                @endforeach

            </div>

        </div>

    </section>
</div>

@include('layout-footer')


</body>

</html>

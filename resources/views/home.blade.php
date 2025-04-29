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
                                    <p><i class="fa-solid fa-eye"></i>Lượt nghe: {{$p->luot_nghe}}</p>
                                    <p><i class="fa-solid fa-calendar-days"></i>Phát hành: {{ $p->created_at->format('d/m/Y') }}</p>
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
                                    <p><i class="fa-solid fa-eye"></i>Lượt nghe: {{$p->luot_nghe}}</p>
                                    <p><i class="fa-solid fa-calendar-days"></i>Phát hành: {{ $p->created_at->format('d/m/Y') }}</p>
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
                    <img src="{{ asset('images/' . $n->image) }}" class="card-img-top"
                        alt="{{ $n->title }}">
                    <div class="card-body">
                        <div class="noidung-dichvu">
                            <h5 class="card-title">{{ $n->tieude }}</h5>
                            <p class="card-text">{!! Str::limit($n->noidung, 100) !!}</p>
                        </div>
                        <a href="{{ route('detail', $n->slug) }}" class="btn btn-primary vertical-button">Xem chi
                            tiết</a>
                    </div>
                </div>
                @endforeach
            </div>
            <h3>MCT Media – Giải Pháp Truyền Thông Cho Mọi Người</h3>
            <div class="info">
                @foreach($dichvu as $dv)
                <figure class="snip1156">
                    <img src="{{ asset('images/' . $dv->image) }}" alt="{{$dv->name}}" />
                    <figcaption>
                        <div>
                            <h2>{{$dv->tieude}} </h2>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const cards = document.querySelectorAll(".carousel .card");
        const prevButton = document.querySelector(".arrow-left");
        const nextButton = document.querySelector(".arrow-right");
        const indicatorContainer = document.querySelector(".carousel-indicator");
        const carousel = document.querySelector(".carousel");

        let currentIndex = 0;
        let startX = 0; // Startpunkt för touch

        createIndicators();
        updateCarousel();
        setInterval(nextImage, 3000); // Chuyển slide mỗi 3 giây
        // Lägg till event listeners
        carousel.addEventListener("touchstart", handleTouchStart, false);
        carousel.addEventListener("touchend", handleTouchEnd, false);
        nextButton.addEventListener("click", nextImage);
        prevButton.addEventListener("click", prevImage);

        cards.forEach((card, index) => {
            card.addEventListener("click", () => {
                if (index === currentIndex) {
                    // card.dataset.flipped = card.dataset.flipped === "true" ? "false" : "true";
                    updateCarousel();
                }
            });
        });

        function createIndicators() {
            indicatorContainer.innerHTML = ""; // Rensa gamla indikatorer

            cards.forEach((_, index) => {
                const indicator = document.createElement("span");
                indicator.classList.add("indicator");
                indicator.dataset.index = index;
                indicator.addEventListener("click", () => goToImage(index));
                indicatorContainer.appendChild(indicator);
            });

            updateIndicators();
        }

        function updateCarousel() {
            cards.forEach((card, index) => {
                let distance = (index - currentIndex + cards.length) % cards.length;
                let scale = distance === 0 ? 1 : 0.8;
                let xOffset = distance === 1 ? 50 : distance === cards.length - 1 ? -50 : 0;
                let zIndex = distance === 0 ? 10 : 5;

                card.style.opacity = distance > 1 && distance < cards.length - 1 ? "0" : "1";
                card.style.pointerEvents = distance === 0 ? "auto" : "none";

                const isFlipped = card.dataset.flipped === "true";
                card.style.transform =
                    `translateX(${xOffset}px) scale(${scale}) rotateY(${isFlipped ? 180 : 0}deg)`;
                card.style.zIndex = zIndex;
            });

            updateIndicators();
        }

        function updateIndicators() {
            document.querySelectorAll(".indicator").forEach((dot, index) => {
                dot.classList.toggle("active", index === currentIndex);
            });
        }

        function goToImage(index) {
            currentIndex = index;
            resetAllFlippedCards();
            updateCarousel();
        }

        function nextImage() {
            currentIndex = (currentIndex + 1) % cards.length;
            resetAllFlippedCards();
            updateCarousel();
        }

        function prevImage() {
            currentIndex = (currentIndex - 1 + cards.length) % cards.length;
            resetAllFlippedCards();
            updateCarousel();
        }

        function resetAllFlippedCards() {
            cards.forEach(card => (card.dataset.flipped = "false"));
        }

        function handleTouchStart(event) {
            startX = event.touches[0].clientX;
        }

        function handleTouchEnd(event) {
            let diffX = startX - event.changedTouches[0].clientX;

            if (diffX > 50) nextImage();
            else if (diffX < -50) prevImage();
        }
    });
</script>

<script>
    $(".hover").mouseleave(
        function() {
            $(this).removeClass("hover");
        }
    );
</script>

<script>
    wrapnav();
    slideAudio();
</script>
</body>

</html>
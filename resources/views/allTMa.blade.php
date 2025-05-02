@include('layout-header')
<div class="container" style="margin-bottom: 30px;">
    <section class="snake-content">
        <div class="content-left-item">
            <h2 style="margin-top: 10px" class="haunted-blog-header">Tất cả truyện ma</h2>

            <div class="slider-container">
                <div class="slider-wrapper">
                    <div class="slider">
                        @foreach ($audio->chunk(16) as $index => $group)
                            <div class="slide-group {{ $loop->first ? 'active' : '' }}">
                                @foreach ($group as $p)
                                    <div class="card" data-tilt>
                                        <a href="{{ route('detail', $p->slug) }}">
                                            <img src="{{ asset('uploads/images/' . $p->image) }}"
                                                title="{{ $p->ten }}" alt="{{ $p->ten }}">
                                            <h3>{{ $p->ten }}</h3>
                                            <p><i class="fa-solid fa-eye"></i>Lượt nghe: {{ $p->luot_nghe }}</p>
                                            <p><i class="fa-solid fa-calendar-days"></i>Phát hành:
                                                {{ $p->created_at->format('d/m/Y') }}</p>
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



    </section>
</div>
@include('layout-footer')
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

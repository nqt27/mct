@include('layout-header')
<div class="container" style="margin-bottom: 30px;">
    <section class="snake-content">
        <div class="content-left-item">
            <h2 style="margin-top: 10px" class="haunted-blog-header">Tất cả truyện ma</h2>

            <div class="slider-container">
                <div class="slider-wrapper">
                    <div class="slider">

                        <div class="slide-group active">
                        @foreach ($audio as $p)
                            <div class="card" data-tilt>
                                <a href="{{ route('detail', $p->slug) }}">
                                    <img src="{{ asset('uploads/images/' . $p->image) }}"
                                        title="{{ $p->ten }}" alt="{{ $p->ten }}">
                                    <h3>{{ $p->ten }}</h3>
                                    <p><i class="fa-solid fa-eye"></i>Lượt nghe: {{$p->luot_nghe}}</p>
                                    <p><i class="fa-solid fa-calendar-days"></i>Phát hành: {{$p->created_at}}</p>
                                </a>
                            </div>
                            @endforeach
                        </div>



                    </div>
                </div>



            </div>
            <div id="pagination" class="pagination"></div>

        </div>



    </section>
</div>
@include('layout-footer')
<script>
    const itemsPerPage = 16;
    const cards = Array.from(document.querySelectorAll(".card")); // Đổi từ .library-card thành .card
    const pagination = document.getElementById("pagination");
    const libraryGrid = document.getElementById("libraryGrid");

    let currentPage = 1;

    function renderPage(page) {
        // Ẩn tất cả card
        cards.forEach(card => {
            card.style.display = "none";
        });

        const start = (page - 1) * itemsPerPage;
        const end = page * itemsPerPage;

        // Hiện card của trang hiện tại
        cards.slice(start, end).forEach(card => {
            card.style.display = "block";
            card.style.opacity = 0;
            card.style.transition = "opacity 0.5s ease, transform 0.3s ease";
            card.style.transform = "scale(0.95)";
            requestAnimationFrame(() => {
                card.style.opacity = 1;
                card.style.transform = "scale(1)";
            });
        });

        renderPagination();

        // Cuộn lên đầu grid mỗi khi đổi trang
        //  Cuộn lên đầu trang thay vì chỉ scroll đến libraryGrid
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    function renderPagination() {
        const totalPages = Math.ceil(cards.length / itemsPerPage);
        pagination.innerHTML = "";

        for (let i = 1; i <= totalPages; i++) {
            const btn = document.createElement("button");
            btn.innerText = i;
            if (i === currentPage) btn.classList.add("active");
            btn.addEventListener("click", () => {
                currentPage = i;
                renderPage(currentPage);
            });
            pagination.appendChild(btn);
        }
    }

    // Gọi khi load lần đầu
    renderPage(currentPage);
</script>

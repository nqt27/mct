@include('layout-header')
<section id="blog-root">
    <h2 class="haunted-blog-header">Blog Truyện Ma</h2>
    <div class="haunted-blog-grid" id="hauntedBlogGrid">
        <article class="haunted-blog-card">
            <img src="https://picsum.photos/seed/1/400/200" alt="Truyền thuyết làng hoang">
            <div class="haunted-blog-card-content">
                <h3>Truyền Thuyết Làng Hoang</h3>
                <p>Những lời đồn về bóng ma xuất hiện cuối đêm trong ngôi làng vắng...</p>
                <a href="#">Đọc tiếp →</a>
            </div>
        </article>
        <article class="haunted-blog-card">
            <img src="https://picsum.photos/seed/2/400/200" alt="Chuyện ma học đường">
            <div class="haunted-blog-card-content">
                <h3>Chuyện Ma Học Đường</h3>
                <p>Hành lang ký túc xá sau giờ học luôn vang vọng tiếng thì thầm...</p>
                <a href="#">Đọc tiếp →</a>
            </div>
        </article>
        <article class="haunted-blog-card">
            <img src="https://picsum.photos/seed/3/400/200" alt="Búp bê ám ảnh">
            <div class="haunted-blog-card-content">
                <h3>Búp Bê Ám Ảnh</h3>
                <p>Có người nói tiếng hát ngân nga từ căn phòng chứa búp bê cũ...</p>
                <a href="#">Đọc tiếp →</a>
            </div>
        </article>
        <!-- Thêm card nếu cần -->
    </div>
</section>
@include('layout-footer')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const cards = document.querySelectorAll('#blog-root .haunted-blog-card');
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.2
        });
        cards.forEach(card => observer.observe(card));
    });
</script>

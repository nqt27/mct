@include('layout-header')
<section id="blog-root">
    <h2 class="haunted-blog-header">Review Truyện Ma</h2>
    <div class="haunted-blog-grid" id="hauntedBlogGrid">
    @foreach($review as $b)
        <article class="haunted-blog-card">
            <img src="{{ asset('images/' . $b->image) }}" alt="{{$b->tieude}}">
            <div class="haunted-blog-card-content">
                <h3>{{$b->tieude}}</h3>
                <p>{!! Str::limit($b->noidung, 100) !!}</p>
                <a href="{{ route('review.detail', $b->slug) }}">Đọc tiếp →</a>

            </div>
        </article>
        @endforeach
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

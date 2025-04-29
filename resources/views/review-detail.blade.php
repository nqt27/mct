@include('layout-header')
<section id="detail-blog-root">
    <h1 class="detail-blog-title">{{$review->tieude}}</h1>
    <img class="detail-blog-cover" src="{{ asset('images/' . $review->image) }}" alt="{{$review->tieude}}">
    <div class="detail-blog-content">
        {!!$review->noidung!!}
    </div>
</section>
@include('layout-footer')
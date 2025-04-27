@include('layout-header')
<section id="detail-blog-root">
    <h1 class="detail-blog-title">{{$blog->tieude}}</h1>
    <img class="detail-blog-cover" src="{{ asset('images/' . $blog->image) }}" alt="{{$blog->tieude}}">
    <div class="detail-blog-content">
        {!!$blog->noidung!!}
    </div>
</section>
@include('layout-footer')
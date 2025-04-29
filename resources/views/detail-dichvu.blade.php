@include('layout-header')
<section id="detail-blog-root">
    <h1 class="detail-blog-title">{{$dichvu->tieude}}</h1>
    <img class="detail-blog-cover" src="{{ asset('images/' . $dichvu->image) }}" alt="{{$dichvu->tieude}}">
    <div class="detail-blog-content">
        {!!$dichvu->noidung!!}
    </div>
</section>
@include('layout-footer')
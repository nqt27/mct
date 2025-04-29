@include('layout-header')

<div class="container" style="margin-bottom: 30px;">

    <section class="snake-content">

        <div class="content-left-item post">

            <h3 class="dvsxh3">MCT Media – Giải Pháp Truyền Thông Cho Mọi Người</h3>
            <div class="info">
                @foreach($dichvu as $dv)
                <figure class="snip1156">
                    <img src="{{ asset('images/' . $dv->image) }}" alt="sample62" />
                    <figcaption>
                        <div>
                            <h2>{{$dv->tieude}}</h2>
                        </div>
                        <div>
                            <!-- <p>
                                {!! Str::limit($dv->noidung, 100) !!}</p> -->
                        </div>
                    </figcaption>
                    <a href="{{ route('dvsx.detail', $dv->slug) }}"></a>
                </figure>
                @endforeach
            </div>

        </div>

    </section>
</div>

@include('layout-footer')
@include('layout-header')
<div class="container" style="margin-bottom: 30px;">
    <section class="snake-audio-content">
        <div class="content-left-item">
            <div class="content">
                <h1>{{$dichvu->tieude}}</h1>
                <p>{!!$dichvu->noidung!!}</p>
            </div>
        </div>
    </section>
</div>
@include('layout-footer')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('js/app.js')}}"></script>
<script>
    wrapnav();
    slideAudio();
</script>
</body>

</html>
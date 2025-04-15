@include('admin/layout-header')
<div class="be-content">
    <div class="page-head">
        <h2 class="page-head-title">SEO</h2>
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb page-head-nav">
                <li class="breadcrumb-item"><a href="{{route('admin')}}">Admin</a></li>
                <li class="breadcrumb-item active">Thêm bài viết</li>
            </ol>
        </nav>
    </div>

    <div class="col-md-12">
        <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">Thiết lập SEO

            </div>


            <div class="card-body">
                <form style="width: 75%;" id="audio-seo-form" method="post">
                    @csrf
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Keywword chính: </label>
                        <div class="col-12 col-sm-8 col-lg-8">
                            <input class="form-control" type="text" placeholder="Keywword chính" id="keyword_focus" name="keyword_focus">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">SEO Title:</label>
                        <div class="col-12 col-sm-8 col-lg-8">
                            <input class="form-control" type="text" placeholder="SEO Title" name="seo_title" id="seo_title">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">SEO Keywords:</label>
                        <div class="col-12 col-sm-8 col-lg-8">
                            <input class="form-control" type="text" placeholder="SEO Keywords" name="seo_keywords">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">SEO Description:</label>
                        <div class="col-12 col-sm-8 col-lg-8">
                            <textarea name="seo_description" style="width: 100%; height: 120px; padding: 10px;" id="seo_description" placeholder="SEO Description"></textarea>
                        </div>
                    </div>
                    <button type="button" id="submit-all" class="btn btn-primary" style="margin: 0 5px;float:right;">Lưu bài viết</button>
                    <button type="button" class="btn btn-secondary" style="margin: 0 5px;float:right;"><a href="{{route('admin')}}">Trở về</a></button>
                </form>


            </div>
        </div>
    </div>

</div>
</div>
</div>
@include('admin/layout-footer')
<script src="{{asset('assets\lib\jquery\jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets\lib\perfect-scrollbar\js\perfect-scrollbar.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets\lib\bootstrap\dist\js\bootstrap.bundle.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets\js\app.js')}}" type="text/javascript"></script>



<script src="{{asset('assets\lib\summernote\summernote-bs4.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets\lib\summernote\summernote-ext-beagle.js')}}" type="text/javascript"></script>
<script src="{{asset('assets\lib\parsley\parsley.min.js')}}" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function() {
        //-initialize the javascript
        App.init();
        $('form').parsley();
    });
</script>
</body>

</html>
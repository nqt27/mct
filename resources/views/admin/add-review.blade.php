@include('admin/layout-header')

<div class="content-page">
    <div class="content">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Thêm sản phẩm</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="main-content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-border-color card-border-color-primary">
                        <div class="card-body" style="flex-direction: row; justify-content: normal">
                            <button class="btn btn-primary waves-effect waves-light" id="submit-all"><i class="fas fa-save mr-1"></i><span>Lưu sản phẩm</span></button>
                            <a href="{{route('audio.index')}}" class="btn btn-secondary waves-effect waves-light" type="button"><span>Trở về</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <div class="card card-border-color card-border-color-primary">
                        <div class="card-header bg-info">
                            <h3 class="card-title text-white mb-0">Trạng thái</h3>
                        </div>
                        <div class="card-body">
                            <form style="width: 100%;" id="audio-info-form" method="post">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-3 control-label">Đường dẫn mẫu</label>
                                    <div class="col-sm-9">
                                        <p class="form-control-static" id="url-simple"></p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 control-label"></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" required="" placeholder="Đường dẫn" name="slug" id="audio-url">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 control-label">Tên bài viết</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" required="" placeholder="Tên bài viết" name="tieude" id="name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 control-label">Nội dung</label>
                                    <div class="col-sm-9">
                                        <textarea id="editor1" class="summernote" name="noidung"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row pt-1">
                                    <label class="col-sm-3 control-label">Danh mục cấp 1</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="select-parent" name="menu_id">
                                            <option value="">Chọn danh mục</option>
                                            @foreach($menu as $m)
                                            @if(is_null($m->parent_id))
                                            <option value="{{$m->id}}">{{$m->name}}</option>

                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row pt-1">
                                    <label class="col-sm-3 control-label">Danh mục cấp 2</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="select-child" name="menu_id2">
                                        </select>
                                    </div>
                                </div>


                            </form>
                        </div>
                    </div>

                    <div class="card card-border-color card-border-color-primary">
                        <div class="card-header bg-info">
                            <h3 class="card-title text-white mb-0">Trạng thái
                                <button class="btn btn-space btn-success" onclick="checkSEO()" style="float: right;"><span>Kiểm tra SEO</span></button>
                            </h3>
                        </div>

                        <div class="card-body">
                            <form style="width: 100%;" id="audio-seo-form" method="post" action="{{ route('audio.store') }}">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-3 control-label">Keywword chính: </label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" placeholder="Keywword chính" id="keyword_focus" name="keyword_focus">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 control-label">SEO Title:</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" placeholder="SEO Title" name="seo_title" id="seo_title">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 control-label">SEO Keywords:</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" placeholder="SEO Keywords" name="seo_keywords">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 control-label">SEO Description:</label>
                                    <div class="col-sm-9">
                                        <textarea name="seo_description" style="width: 100%; height: 120px; padding: 10px;" id="seo_description" placeholder="SEO Description"></textarea>
                                    </div>
                                </div>

                            </form>


                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card card-border-color card-border-color-primary">
                        <div class="card-header bg-info">
                            <h3 class="card-title text-white mb-0">Trạng thái</h3>
                        </div>
                        <div class="card-body" id="audio-status-form">
                            <div class="form-group" style="justify-content: space-between; align-items: center;">
                                <label style="padding: 0" class="col-12 col-sm-3 col-form-label"><strong>Hiển thị</strong></label>
                                <div style="padding: 0" class="col-12 col-sm-8 col-lg-6">
                                    <div class="switch-button switch-button-success switch-button-xs">
                                        <input type="checkbox" class="status-checkbox" data-switch="success" checked name="display" id="display">
                                        <label for="display" data-on-label="Yes" data-off-label="No"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" style="justify-content: space-between; align-items: center;">
                                <label style="padding: 0" class="col-12 col-sm-3 col-form-label"><strong>Mới</strong></label>
                                <div style="padding: 0" class="col-12 col-sm-8 col-lg-6">
                                    <div class="switch-button switch-button-success switch-button-xs">
                                        <input type="checkbox" class="status-checkbox" data-switch="success" checked name="moi" id="is_new">
                                        <label for="is_new" data-on-label="Yes" data-off-label="No"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-border-color card-border-color-primary">
                        <div class="card-header bg-info">
                            <h3 class="card-title text-white mb-0">Trạng thái</h3>
                        </div>
                        <div class="card-body">
                            <div id="custom-preview" class="custom-preview" style="margin: 20px">
                                <!-- Các ảnh preview sẽ hiển thị ở đây -->
                            </div>
                            <form style="max-width: 100%" method="post" action="{{route('audio.store')}}" enctype="multipart/form-data" class="dropzone dz-clickable col-sm-9" id="my-dropzone">
                                @csrf
                                <div class="dz-message">
                                    <div class="icon"><span class="mdi mdi-cloud-upload"></span></div>
                                    <h4>Kéo thả hình vào đây</h4>
                                    <div class="dropzone-mobile-trigger needsclick"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- <div class="card card-border-color card-border-color-primary">
                    <div class="card-header card-header-divider">Hình ảnh sản phẩm</div>
                    <div class="card-body">
                        <div id="custom-preview1" class="custom-preview" style="margin: 20px;display: flex;flex-wrap: wrap;justify-content: center;">

                        </div>
                        <form method="post" action="{{route('audio.store')}}" enctype="multipart/form-data" class="dropzone dz-clickable col-sm-9" id="my-dropzone1">
                            @csrf
                            <div class="dz-message">
                                <div class="icon"><span class="mdi mdi-cloud-upload"></span></div>
                                <h4>Kéo thả hình vào đây</h4>
                                <div class="dropzone-mobile-trigger needsclick"></div>
                            </div>
                        </form>
                    </div>
                </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@include('admin/layout-footer')

<!-- Vendor js -->
<script src="{{asset('assets\js\vendor.min.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('assets\libs\summernote\summernote-bs4.min.js')}}" type="text/javascript"></script>
<!-- Init js -->
<script src="{{asset('assets\js\pages\form-summernote.init.js')}}"></script>
<!-- Dropzone JS -->
<script src="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/min/dropzone.min.js"></script>

<script src="{{asset('js\feature.js')}}" type="text/javascript"></script>

<!-- App js -->
<script src="{{asset('assets\js\app.min.js')}}"></script>



<!-- Dropzone -->
<script>
    $(document).ready(function() {
        // Handle parent category change
        $('#select-parent').on('change', function() {
            const parentId = $(this).val();
            console.log(parentId);

            const childSelect = $('#select-child');

            // Clear existing options
            childSelect.empty();
            childSelect.append('<option value="">Chọn thể loại</option>');

            if (parentId) {
                // Get subcategories via AJAX
                $.ajax({
                    url: '/admin/get-review-subcategories/' + parentId,
                    method: 'GET',
                    success: function(response) {
                        if (response.subcategories && response.subcategories.length > 0) {
                            response.subcategories.forEach(function(subcategory) {
                                childSelect.append(`<option value="${subcategory.id}">${subcategory.name}</option>`);
                            });
                            childSelect.prop('disabled', false);
                        } else {
                            childSelect.prop('disabled', true);
                        }
                    },
                    error: function() {
                        childSelect.prop('disabled', true);
                    }
                });
            } else {
                childSelect.prop('disabled', true);
            }
        });
    });
    Dropzone.autoDiscover = false;
    $(document).ready(function() {

        // Khởi tạo Dropzone cho phần tử đầu tiên
        var myDropzone = new Dropzone("#my-dropzone", {
            maxFiles: 1, // Chỉ cho phép tải lên một ảnh
            autoProcessQueue: false, // Ngừng tự động tải lên khi có ảnh
            paramName: "image", // Tên trường khi gửi lên server
            uploadMultiple: false,
            autoDiscover: false,
            previewsContainer: "#custom-preview",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },

            init: function() {
                var myDropzone = this;



                // Khi thêm một ảnh mới, xóa ảnh cũ nếu có
                myDropzone.on("addedfile", function(file) {
                    // Xóa ảnh cũ nếu có
                    var previewContainer = document.getElementById("custom-preview");
                    previewContainer.innerHTML = ""; // Xóa tất cả ảnh cũ trong preview

                    // Tạo phần tử img cho preview của ảnh mới
                    var previewImage = document.createElement("img");
                    previewImage.src = URL.createObjectURL(file); // URL ảnh preview
                    previewImage.alt = file.name;
                    previewImage.className = "custom-preview-image";

                    // Thêm ảnh mới vào vùng custom preview
                    previewContainer.appendChild(previewImage);
                    if (myDropzone.files.length > 1) {
                        myDropzone.removeFile(myDropzone.files[0]); // Xóa ảnh cũ
                    }
                });
            }
        });

        // Khởi tạo Dropzone cho phần tử thứ hai
        // var myDropzone1 = new Dropzone("#my-dropzone1", {
        //     autoProcessQueue: false, // Tắt tự động gửi Dropzone
        //     paramName: "images", // Đặt paramName cho ảnh
        //     addRemoveLinks: true, // Thêm link xóa ảnh
        //     autoDiscover: false,
        //     previewTemplate: `
        //         <div class="dz-preview dz-image-preview">
        //             <div class="dz-image"><img data-dz-thumbnail /></div>

        //         </div>
        //     `,
        //     previewsContainer: "#custom-preview1",
        //     headers: {
        //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        //     },


        // });

        // Xử lý sự kiện khi nhấn nút submit
        $('#submit-all').on('click', function(e) {
            e.preventDefault(); // Ngăn chặn hành động submit mặc định

            // console.log(myDropzone1.getAcceptedFiles());
            // Tạo đối tượng FormData từ form1
            var formData = new FormData($('#audio-info-form')[0]);

            // Lấy dữ liệu từ form SEO
            $('#audio-seo-form').find('input, select, textarea').each(function() {
                if (this.name) {
                    formData.append(this.name, $(this).val());
                }
            });
            // Lấy dữ liệu từ form trạng thái
            $('#audio-status-form').find('input').each(function() {
                if (this.name) {
                    formData.append(this.name, $(this).prop('checked') ? 1 : 0);
                }
            });
            // Lấy dữ liệu ảnh chính từ Dropzone
            var file = myDropzone.getAcceptedFiles()[0];

            if (file) {
                formData.append("image", file);
            }


            // Duyệt qua tất cả các file được chọn trong Dropzone1 và thêm vào FormData



            // Hiển thị tất cả các key trong FormData(tùy chọn)
            for (var pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]); // pair[0] là key, pair[1] là value
            }

            // Gửi request AJAX với FormData đã gộp
            $.ajax({
                url: '/admin/add-review', // Đường dẫn route
                method: 'POST',
                data: formData,
                processData: false, // Không xử lý dữ liệu
                contentType: false, // Không thiết lập kiểu content type
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Hiển thị thông báo thành công
                    Swal.fire({
                        title: 'Thành công!',
                        text: 'Dữ liệu đã được gửi thành công.',
                        icon: 'success',
                        timer: 1000, // Thời gian tự động đóng sau 1 giây
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        window.location.href = '/admin/review';
                    });

                    // Xóa tất cả các tệp sau khi gửi thành công
                    myDropzone.removeAllFiles();
                    // myDropzone1.removeAllFiles();

                },
                error: function(xhr) {
                    // Xử lý khi lỗi xảy ra
                    alert('Error submitting form');
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        //-initialize the javascript
        urlaudio();
    });
</script>
</body>

</html>
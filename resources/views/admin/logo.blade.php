@include('admin/layout-header')
<div class="content-page">
    <div class="content">
        <div class="main-content container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Thay đổi logo</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-border-color card-border-color-primary">
                        <div class="card-header card-header-divider">
                            <button class="btn btn-primary waves-effect waves-light" type="submit" id="submit"><i class="fas fa-save mr-1"></i><span>Lưu logo</span></button>
                            <a href="{{route('admin')}}" class="btn btn-secondary waves-effect waves-light" type="button"><span>Trở về</span></a>
                            <!-- <button class="btn btn-space btn-primary" style="float: right;" type="submit" id="submit">Lưu logo</button>
                            <button class="btn btn-space btn-secondary" style="float: right;">Hủy</button> -->
                        </div>
                        <div class="card-body" style="display:flex; flex-direction:column; align-items: center;">
                            <div id="custom-preview" class="custom-preview preview-logo" style="margin: 20px">
                                <!-- Các ảnh preview sẽ hiển thị ở đây -->
                            </div>
                            <form style="max-width: 100%" method="post" action="{{route('logo.store')}}" enctype="multipart/form-data" class="dropzone dz-clickable col-sm-9" id="my-dropzone">
                                @csrf
                                <div class="dz-message">
                                    <div class="icon"><span class="mdi mdi-cloud-upload"></span></div>
                                    <h4>Kéo thả hình vào đây</h4>
                                    <div class="dropzone-mobile-trigger needsclick"></div>
                                </div>
                            </form>

                        </div>

                    </div>
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
<!-- Dropzone JS -->
<script src="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/min/dropzone.min.js"></script>

<script src="{{asset('js\feature.js')}}" type="text/javascript"></script>

<!-- App js -->
<script src="{{asset('assets\js\app.min.js')}}"></script>

<!-- Dropzone -->
<script>
    Dropzone.autoDiscover = false;
    $(document).ready(function() {

        // Khởi tạo Dropzone cho phần tử đầu tiên
        var myDropzone = new Dropzone("#my-dropzone", {
            maxFiles: 1, // Chỉ cho phép tải lên một ảnh
            autoProcessQueue: false, // Ngừng tự động tải lên khi có ảnh
            paramName: "logo", // Tên trường khi gửi lên server
            uploadMultiple: false,
            previewsContainer: "#custom-preview",
            autoDiscover: false,
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

        // Xử lý sự kiện khi nhấn nút submit
        $('#submit').on('click', function(e) {
            e.preventDefault(); // Ngăn chặn hành động submit mặc định

            // Tạo đối tượng FormData từ form1
            var formData = new FormData();


            // Lấy dữ liệu ảnh chính từ Dropzone
            var file = myDropzone.getAcceptedFiles()[0];
            if (!file) {
                Swal.fire({
                    title: 'Lỗi!',
                    text: 'Vui lòng tải lên ít nhất một file!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return; // Dừng xử lý nếu không có file
            }
            if (file) {
                formData.append("logo", file);
            }




            // Hiển thị tất cả các key trong FormData(tùy chọn)
            for (var pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]); // pair[0] là key, pair[1] là value
            }

            // Gửi request AJAX với FormData đã gộp
            $.ajax({
                url: '/admin/logo', // Đường dẫn route
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
                        window.location.href = '/';
                    });

                    // Xóa tất cả các tệp sau khi gửi thành công
                    myDropzone.removeAllFiles();

                },
                error: function(xhr) {
                    // Xử lý khi lỗi xảy ra
                    alert('Error submitting form');
                }
            });
        });
    });
</script>

</body>

</html>
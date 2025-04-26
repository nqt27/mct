@include('admin/layout-header')

<div class="content-page">
    <div class="content">
        <div class="main-content container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Cấu hình website</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-border-color card-border-color-primary">
                        <div class="card-body" style="flex-direction: row; justify-content: normal">
                            <button class="btn btn-primary waves-effect waves-light" id="submit-all">
                                <i class="fas fa-save mr-1"></i><span>Lưu thông tin</span>
                            </button>
                            <a href="{{route('admin')}}" class="btn btn-secondary waves-effect waves-light">
                                <span>Trở về</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h3 class="card-title text-white mb-0">Liên kết mạng xã hội</h3>
                        </div>
                        <div class="card-body">
                            <form id="social-form">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">
                                        <i class="fab fa-facebook text-primary mr-1"></i>Facebook
                                    </label>
                                    <div class="col-md-10">
                                        <input type="url" class="form-control" name="facebook"
                                            value="{{ $info->facebook ?? '' }}"
                                            placeholder="https://facebook.com/your-page">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">
                                        <i class="fab fa-youtube text-danger mr-1"></i>Youtube
                                    </label>
                                    <div class="col-md-10">
                                        <input type="url" class="form-control" name="youtube"
                                            value="{{ $info->youtube ?? '' }}"
                                            placeholder="https://youtube.com/@your-channel">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">
                                        <i class="fab fa-instagram text-warning mr-1"></i>Instagram
                                    </label>
                                    <div class="col-md-10">
                                        <input type="url" class="form-control" name="instagram"
                                            value="{{ $info->instagram ?? '' }}"
                                            placeholder="https://instagram.com/your-profile">
                                    </div>
                                </div>

                               

                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">
                                        <i class="fab fa-tiktok text-dark mr-1"></i>TikTok
                                    </label>
                                    <div class="col-md-10">
                                        <input type="url" class="form-control" name="tiktok"
                                            value="{{ $info->tiktok ?? '' }}"
                                            placeholder="https://tiktok.com/@your-account">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">
                                        <i class="fas fa-phone text-success mr-1"></i>Điện thoại
                                    </label>
                                    <div class="col-md-10">
                                        <input type="tel" class="form-control" name="phone"
                                            value="{{ $info->phone ?? '' }}"
                                            placeholder="0123456789"
                                            pattern="[0-9]{10,11}">
                                        <small class="form-text text-muted">Nhập số điện thoại từ 10-11 số</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">
                                        <i class="fas fa-envelope text-primary mr-1"></i>Email
                                    </label>
                                    <div class="col-md-10">
                                        <input type="email" class="form-control" name="email"
                                            value="{{ $info->email ?? '' }}"
                                            placeholder="example@domain.com">
                                        <small class="form-text text-muted">Nhập địa chỉ email liên hệ</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">
                                        <i class="fas fa-map-marked-alt text-success mr-1"></i>Địa chỉ
                                    </label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="address"
                                            value="{{ $info->address ?? '' }}"
                                            placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành phố">
                                        <small class="form-text text-muted">Nhập địa chỉ liên hệ</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">
                                        <i class="fas fa-comments text-primary mr-1"></i>Zalo
                                    </label>
                                    <div class="col-md-10">
                                        <input type="url" class="form-control" name="zalo"
                                            value="{{ $info->zalo ?? '' }}"
                                            placeholder="https://zalo.me/your-number">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">
                                        <i class="fas fa-map-marker-alt text-danger mr-1"></i>Google Maps
                                    </label>
                                    <div class="col-md-10">
                                        <textarea class="form-control" name="google_maps_iframe" rows="4"
                                            placeholder="<iframe src='https://www.google.com/maps/embed...'></iframe>">{{ $info->google_maps_iframe ?? '' }}</textarea>
                                        <small class="form-text text-muted">Nhập mã nhúng từ Google Maps</small>

                                        <!-- Preview Map -->
                                        <div class="mt-3 border rounded" id="map-preview" style="min-height: 300px; display: none;">
                                            <div class="bg-light border-bottom p-2">
                                                <small><i class="fas fa-eye mr-1"></i>Xem trước bản đồ</small>
                                            </div>
                                            <div id="map-preview-content" class="p-2">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Add after the Google Maps section, before the form closing tag -->
                               
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin/layout-footer')
<style>
    .cke_notification {
        display: none !important;
    }
</style>
<!-- Vendor js -->
<script src="{{asset('assets\js\vendor.min.js')}}"></script>

<!-- Plugins js-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- App js -->
<script src="{{asset('assets\js\app.min.js')}}" type="text/javascript"></script>

<!-- Add CKEditor CDN before your scripts -->
<script src="//cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>

<script>
    $(document).ready(function() {
        // Initialize CKEditor
        CKEDITOR.replace('payment_info', {
            height: 300,
            removePlugins: 'elementspath',
            resize_enabled: false,
            entities: false
        });

        // Validate all required fields
        function validateForm() {
            let isValid = true;
            const errors = [];

            // Phone validation
            const phone = $('input[name="phone"]').val().trim();
            if (!phone) {
                errors.push('Vui lòng nhập số điện thoại');
                $('input[name="phone"]').addClass('is-invalid');
                isValid = false;
            } else if (phone.length < 10 || phone.length > 11) {
                errors.push('Số điện thoại phải từ 10-11 số');
                $('input[name="phone"]').addClass('is-invalid');
                isValid = false;
            }

            // Social media URLs validation
            const socialInputs = {
                facebook: 'Facebook',
                youtube: 'Youtube',
                instagram: 'Instagram',
                tiktok: 'TikTok',
                zalo: 'Zalo',
            };

            Object.entries(socialInputs).forEach(([field, label]) => {
                const value = $(`input[name="${field}"]`).val().trim();
                if (value && !isValidUrl(value)) {
                    errors.push(`Link ${label} không hợp lệ`);
                    $(`input[name="${field}"]`).addClass('is-invalid');
                    isValid = false;
                }
            });

            // Google Maps validation
            const mapsIframe = $('textarea[name="google_maps_iframe"]').val().trim();

            

            if (mapsIframe && !mapsIframe.match(/<iframe[^>]*src=['"]https:\/\/www\.google\.com\/maps\/embed[^>]*>/)) {
                errors.push('Mã nhúng Google Maps không hợp lệ');
                $('textarea[name="google_maps_iframe"]').addClass('is-invalid');
                isValid = false;
            }

            // Show errors if any
            if (!isValid) {
                Swal.fire({
                    title: 'Lỗi!',
                    html: errors.join('<br>'),
                    icon: 'error'
                });
            }

            return isValid;
        }

        // URL validator
        function isValidUrl(url) {
            try {
                new URL(url);
                return true;
            } catch {
                return false;
            }
        }

        // Form submission handler
        $('#submit-all').on('click', function(e) {
            e.preventDefault();

            if (!validateForm()) {
                return;
            }

            const formData = new FormData($('#social-form')[0]);

            // Add CKEditor content
            for (var pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]); // pair[0] là key, pair[1] là value
            }
            Swal.fire({
                title: 'Xác nhận?',
                text: 'Bạn có chắc chắn muốn lưu thông tin?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("web-config.store") }}',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function() {
                            Swal.fire({
                                title: 'Đang xử lý...',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading()
                                }
                            });
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Thành công!',
                                text: 'Đã cập nhật thông tin thành công',
                                icon: 'success',
                                timer: 1500
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Lỗi!',
                                text: 'Không thể cập nhật thông tin. Vui lòng thử lại.',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        });

        // Auto-format URLs on blur
        $('input[type="url"]').on('blur', function() {
            let url = $(this).val().trim();
            if (url && !url.startsWith('http://') && !url.startsWith('https://')) {
                $(this).val('https://' + url);
            }
        });

        // Phone number formatter
        $('input[name="phone"]').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });



        // Remove validation highlights on input
        $('input, textarea').on('input', function() {
            $(this).removeClass('is-invalid');
            $(this).next('.form-text').removeClass('text-danger').addClass('text-muted');
        });

        // Handle Google Maps preview
        function updateMapPreview() {
            const iframe = $('textarea[name="google_maps_iframe"]').val().trim();
            const previewDiv = $('#map-preview');
            const previewContent = $('#map-preview-content');

            if (iframe) {
                const sanitizedIframe = iframe
                    .replace(/onclick/gi, 'data-onclick')
                    .replace(/onerror/gi, 'data-onerror')
                    .replace(/onload/gi, 'data-onload');

                previewContent.html(sanitizedIframe);
                previewDiv.show();
            } else {
                previewContent.empty();
                previewDiv.hide();
            }
        }

        // Validate iframe input
        function validateMapInput() {
            const iframe = $('textarea[name="google_maps_iframe"]').val().trim();

            // Reset validation state
            $('textarea[name="google_maps_iframe"]')
                .removeClass('is-invalid')
                .next('.form-text')
                .removeClass('text-danger')
                .addClass('text-muted')
                .text('Nhập mã nhúng từ Google Maps');

            if (!iframe) {
                return true; // Empty is allowed
            }

            if (!iframe.match(/<iframe[^>]*src=['"]https:\/\/www\.google\.com\/maps\/embed[^>]*>/)) {
                $('textarea[name="google_maps_iframe"]')
                    .addClass('is-invalid')
                    .next('.form-text')
                    .addClass('text-danger')
                    .text('Vui lòng nhập mã nhúng Google Maps hợp lệ');
                return false;
            }

            return true;
        }

        // Update event listeners
        $('textarea[name="google_maps_iframe"]').on('change', function() {
            updateMapPreview();
        }).on('blur', function() {
            validateMapInput();
        });

        // Initial preview
        updateMapPreview();

        // Validate Google Maps link
        $('input[name="google_maps_link"]').on('blur', function() {
            let url = $(this).val().trim();
            if (url && !url.match(/^https:\/\/(goo\.gl\/maps\/|google\.com\/maps)/)) {
                $(this).addClass('is-invalid');
                $(this).next('.form-text')
                    .addClass('text-danger')
                    .text('Vui lòng nhập link Google Maps hợp lệ');
            } else {
                $(this).removeClass('is-invalid');
                $(this).next('.form-text')
                    .removeClass('text-danger')
                    .text('Nhập link rút gọn từ Google Maps');
            }
        });

        // Validate iframe
        $('textarea[name="google_maps_iframe"]').on('blur', function() {
            let iframe = $(this).val().trim();
            if (iframe && !iframe.match(/<iframe[^>]*src=['"]https:\/\/www\.google\.com\/maps\/embed[^>]*>/)) {
                $(this).addClass('is-invalid');
                $(this).next('.form-text')
                    .addClass('text-danger')
                    .text('Vui lòng nhập mã nhúng Google Maps hợp lệ');
            } else {
                $(this).removeClass('is-invalid');
                $(this).next('.form-text')
                    .removeClass('text-danger')
                    .text('Hoặc nhập mã nhúng (iframe) từ Google Maps');
            }
        });
    });
</script>

</body>

</html>
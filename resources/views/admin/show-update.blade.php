@include('admin/layout-header')

<div class="content-page">
    <div class="content">
        <div class="main-content container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Thêm Audio</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-border-color card-border-color-primary">
                        <div class="card-body" style="flex-direction: row; justify-content: normal">
                            <button class="btn btn-primary waves-effect waves-light" id="submit-all"><i class="fas fa-save mr-1"></i><span>Lưu</span></button>
                            <a href="{{route('audio.index')}}" class="btn btn-secondary waves-effect waves-light" type="button"><span>Trở về</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <!-- Audio Type Selection -->
                    <div class="card card-border-color card-border-color-primary">
                        <div class="card-header bg-info">
                            <h3 class="card-title text-white mb-0">Loại Audio</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group" style="justify-content: space-between; align-items: center;">
                                <label style="padding: 0" class="col-12 col-sm-3 col-form-label">
                                    <strong>Audio nhiều tập</strong>
                                </label>
                                <div style="padding: 0" class="col-12 col-sm-8 col-lg-6">
                                    <div class="switch-button switch-button-success switch-button-xs">
                                        <input type="checkbox" class="status-checkbox" data-switch="success" name="is_series" id="is_series" {{ $audio->is_series ? 'checked' : '' }}>
                                        <label for="is_series" data-on-label="Yes" data-off-label="No"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Basic Info Form -->
                    <div class="card card-border-color card-border-color-primary">
                        <div class="card-header bg-info">
                            <h3 class="card-title text-white mb-0">Thông tin cơ bản</h3>
                        </div>
                        <div class="card-body">
                            <form id="audio-info-form" method="post" action="{{ route('audio.store') }}">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-3 control-label">Đường dẫn mẫu</label>
                                    <div class="col-sm-9">
                                        <p class="form-control-static" id="url-simple"></p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 control-label"></label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" required="" placeholder="Đường dẫn" name="slug" id="audio-url" value="{{ $audio->slug }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">Tên audio</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" required="" placeholder="Tên audio" name="ten" id="name" value="{{ $audio->ten }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">Tóm tắt</label>
                                    <div class="col-md-9">
                                        <textarea id="editor1" class="summernote" name="tomtat">{{$audio->tomtat}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">Tác giả</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" required="" placeholder="Tác giả" name="tacgia" id="tacgia" value="{{ $audio->tacgia }}">
                                    </div>
                                </div>
                                <!-- Parent Category -->
                                <div class="form-group row pt-1">
                                    <label class="col-md-3 control-label">Danh mục</label>
                                    <div class="col-md-9">
                                        <select class="form-control" id="select-parent" name="menu_id">
                                            <option value="">Chọn danh mục</option>
                                            @foreach($menu as $m)
                                            <option value="{{ $m->id }}"
                                                {{ $selectedMenu && $m->id == $selectedMenu->parent_id ? 'selected' : '' }}>
                                                {{ $m->ten }}
                                            </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>

                                <!-- Child Category -->
                                <div class="form-group row pt-1">
                                    <label class="col-md-3 control-label">Thể loại{{ $audio->theloai->id}}</label>
                                    <div class="col-md-9">
                                        <select class="form-control" id="select-child" name="menu_id2">
                                            <option value="">Chọn thể loại</option>
                                            @if($selectedMenu)
                                            @foreach($menu->where('id', $selectedMenu->parent_id)->first()->submenu ?? [] as $child)
                                            <option value="{{ $child->id }}"
                                                {{ $child->id == $selectedMenu->id ? 'selected' : '' }}>
                                                {{ $child->ten }}
                                            </option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <!-- Single Audio File Upload -->
                                <div class="form-group row single-audio" style="{{ $audio->is_series ? 'display:none' : '' }}">
                                    <label class="col-md-3 control-label">File Audio</label>
                                    <div class="col-md-9">
                                        <input type="file" class="form-control" name="audio_file" accept="audio/*">
                                        <div class="audio-preview">
                                            @if($audio->audio_path)
                                            <div class="card mt-2">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <strong class="text-primary">File hiện tại</strong>
                                                    </div>
                                                    <audio controls style="width:100%">
                                                        <source src="{{ asset('uploads/audio/'.$audio->audio_path) }}" type="audio/mpeg">
                                                    </audio>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Series Chapters -->
                                <div class="series-chapters" style="{{ !$audio->is_series ? 'display:none' : '' }}">
                                    <div id="chapters-container">
                                        @if($audio->is_series && $audio->chapters)
                                        @foreach($audio->chapters as $chapter)
                                        <div class="chapter-entry">
                                            <div class="form-group row">
                                                <label class="col-md-3 control-label">Chapter {{ $loop->iteration }}</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control mb-2"
                                                        name="chapter_titles[]"
                                                        value="{{ $chapter->title }}"
                                                        placeholder="Tên chapter">
                                                    <input type="file" class="form-control"
                                                        name="chapter_files[]"
                                                        accept="audio/*">
                                                    <div class="audio-preview">
                                                        @if($chapter->audio_path)
                                                        <div class="card mt-2">
                                                            <div class="card-body">
                                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                                    <strong class="text-primary">File hiện tại</strong>
                                                                </div>
                                                                <audio controls style="width:100%">
                                                                    <source src="{{ asset('uploads/audio/'.$chapter->audio_path) }}"
                                                                        type="audio/mpeg">
                                                                </audio>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <input type="hidden" name="chapter_ids[]" value="{{ $chapter->id }}">
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <div class="chapter-entry">
                                            <div class="form-group row">
                                                <label class="col-md-3 control-label">Chapter 1</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control mb-2"
                                                        name="chapter_titles[]" placeholder="Tên chapter">
                                                    <input type="file" class="form-control"
                                                        name="chapter_files[]" accept="audio/*">
                                                    <div class="audio-preview"></div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-info mt-2" id="add-chapter">
                                        <i class="fas fa-plus"></i> Thêm chapter
                                    </button>
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
                                    <label class="col-md-3 control-label">Keywword chính: </label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" placeholder="Keywword chính" id="keyword_focus" name="keyword_focus" value="{{ $audio->keyword_focus }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">SEO Title:</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" placeholder="SEO Title" name="seo_title" id="seo_title" value="{{ $audio->seo_title }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">SEO Keywords:</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" placeholder="SEO Keywords" name="seo_keywords" id="seo_keywords" value="{{ $audio->seo_keywords }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">SEO Description:</label>
                                    <div class="col-md-9">
                                        <textarea name="seo_description" style="width: 100%; height: 120px; padding: 10px;" id="seo_description" placeholder="SEO Description">{{ $audio->seo_description}}</textarea>
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
                                <label style="padding: 0" class="col-12 col-sm-3 col-form-label">
                                    <strong>Hiển thị</strong>
                                </label>
                                <div style="padding: 0" class="col-12 col-sm-8 col-lg-6">
                                    <div class="switch-button switch-button-success switch-button-xs">
                                        <input type="checkbox" class="status-checkbox" data-switch="success"
                                            name="display" id="display" {{ $audio->display ? 'checked' : '' }}>
                                        <label for="display" data-on-label="Yes" data-off-label="No"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" style="justify-content: space-between; align-items: center;">
                                <label style="padding: 0" class="col-12 col-sm-3 col-form-label">
                                    <strong>Mới</strong>
                                </label>
                                <div style="padding: 0" class="col-12 col-sm-8 col-lg-6">
                                    <div class="switch-button switch-button-success switch-button-xs">
                                        <input type="checkbox" class="status-checkbox" data-switch="success"
                                            name="moi" id="moi" {{ $audio->moi ? 'checked' : '' }}>
                                        <label for="moi" data-on-label="Yes" data-off-label="No"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" style="justify-content: space-between; align-items: center;">
                                <label style="padding: 0" class="col-12 col-sm-3 col-form-label">
                                    <strong>Nghe nhiều</strong>
                                </label>
                                <div style="padding: 0" class="col-12 col-sm-8 col-lg-6">
                                    <div class="switch-button switch-button-success switch-button-xs">
                                        <input type="checkbox" class="status-checkbox" data-switch="success"
                                            name="nghenhieu" id="nghenhieu" {{ $audio->nghenhieu ? 'checked' : '' }}>
                                        <label for="nghenhieu" data-on-label="Yes" data-off-label="No"></label>
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
                            <form style="max-width: 100%" method="post" action="{{route('audio.store')}}" enctype="multipart/form-data" class="dropzone dz-clickable col-12 col-sm-8 col-lg-8" id="my-dropzone">
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
    Dropzone.autoDiscover = false;
    var myDropzone;
    $(document).ready(function() {
        $(document).ready(function() {
            // Pre-select parent category and load subcategories
            const initialParentId = $('#select-parent').val();
            if (initialParentId) {
                $.ajax({
                    url: '/admin/get-subcategories/' + initialParentId,
                    method: 'GET',
                    success: function(response) {
                        if (response.subcategories && response.subcategories.length > 0) {
                            const childSelect = $('#select-child');
                            childSelect.empty();
                            childSelect.append('<option value="">Chọn thể loại</option>');

                            response.subcategories.forEach(function(subcategory) {
                                const selected = subcategory.id == "{{ $audio->theloai_id }}" ? 'selected' : '';
                                childSelect.append(`<option value="${subcategory.id}" ${selected}>${subcategory.ten}</option>`);
                            });
                            childSelect.prop('disabled', false);
                        }
                    }
                });
            }

            // Handle parent category change
            $('#select-parent').on('change', function() {
                const parentId = $(this).val();
                const childSelect = $('#select-child');

                // Clear existing options
                childSelect.empty();
                childSelect.append('<option value="">Chọn thể loại</option>');

                if (parentId) {
                    // Get subcategories via AJAX
                    $.ajax({
                        url: '/admin/get-subcategories/' + parentId,
                        method: 'GET',
                        success: function(response) {
                            if (response.subcategories && response.subcategories.length > 0) {
                                response.subcategories.forEach(function(subcategory) {
                                    childSelect.append(`<option value="${subcategory.id}">${subcategory.ten}</option>`);
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

        myDropzone = new Dropzone("#my-dropzone", {
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

                // Thêm ảnh từ cơ sở dữ liệu (nếu có)
                var existingImage = "{{ asset('uploads/images/' . $audio->image) }}";
                if (existingImage) {
                    var previewContainer = document.getElementById("custom-preview");

                    // Tạo phần tử img cho preview của ảnh cũ
                    var previewImage = document.createElement("img");
                    previewImage.src = existingImage; // URL ảnh preview
                    previewImage.className = "custom-preview-image";
                    previewImage.alt = "Current Image";

                    // Thêm ảnh vào vùng custom preview
                    previewContainer.appendChild(previewImage);
                }

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


        // Toggle series/single audio sections
        $('#is_series').on('change', function() {
            if ($(this).is(':checked')) {
                $('.single-audio').hide();
                $('.series-chapters').show();
            } else {
                $('.single-audio').show();
                $('.series-chapters').hide();
            }
        });



        // Initial binding for audio preview
        $('input[name="audio_file"], input[name="chapter_files[]"]').on('change', function() {
            handleAudioPreview(this);
        });


        $('#submit-all').on('click', function(e) {
            e.preventDefault();

            var formData = new FormData();
            formData.append('_method', 'PUT');

            // Add basic info form data
            $('#audio-info-form').find('input, select, textarea').each(function() {
                if (this.type === 'checkbox') {
                    formData.append(this.name, $(this).prop('checked') ? 1 : 0);
                } else if (this.name && this.name !== 'chapter_titles[]' && this.name !== 'chapter_files[]') {
                    formData.append(this.name, $(this).val());
                }
            });

            // Add SEO form data
            $('#audio-seo-form').find('input, select, textarea').each(function() {
                formData.append(this.name, $(this).val());
            });

            // Add status checkboxes
            $('#audio-status-form').find('input[type="checkbox"]').each(function() {
                formData.append(this.name, $(this).is(':checked') ? 1 : 0);
            });

            // Add main image if changed
            if (myDropzone.files.length > 0) {
                formData.append("image", myDropzone.files[0]);
            }

            // Handle series/chapters data
            formData.append('is_series', $('#is_series').is(':checked') ? 1 : 0);

            if ($('#is_series').is(':checked')) {
                // Add chapter data
                $('.chapter-entry').each(function(index) {
                    // Get chapter elements
                    const chapterId = $(this).find('input[name="chapter_ids[]"]').val();
                    const title = $(this).find('input[name="chapter_titles[]"]').val();
                    const fileInput = $(this).find('input[name="chapter_files[]"]')[0];

                    // Add existing chapter ID if present
                    if (chapterId) {
                        formData.append(`existing_chapter_ids[${index}]`, chapterId);
                    }

                    // Add chapter title
                    formData.append(`chapter_titles[${index}]`, title || '');

                    // Add chapter file if new one is selected
                    if (fileInput && fileInput.files[0]) {
                        formData.append(`chapter_files[${index}]`, fileInput.files[0]);
                    }
                });
            } else {
                // Add single audio file if changed
                const audioFile = $('input[name="audio_file"]')[0].files[0];
                if (audioFile) {
                    formData.append('audio_file', audioFile);
                }
            }

            // Send AJAX request
            var audioId = "{{ $audio->id }}";
            $.ajax({
                url: `/admin/audio/${audioId}`,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Thành công!',
                        text: 'Audio đã được cập nhật thành công',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '/admin/audio';
                    });
                },
                error: function(xhr) {
                    console.error('Update error:', xhr);
                    let errorMessage = 'Có lỗi xảy ra';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        title: 'Lỗi!',
                        text: errorMessage,
                        icon: 'error'
                    });
                }
            });
        });

    });
</script>
<script>
    function handleAudioPreview(input) {
        const file = input.files[0];
        const previewContainer = $(input).siblings('.audio-preview');

        if (file) {
            // Clear existing preview
            previewContainer.empty();

            // Create audio preview element
            const audioPreview = `
            <div class="card mt-2">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <strong class="text-primary">${file.name}</strong>
                        <button type="button" class="btn btn-sm btn-danger remove-preview">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <audio controls style="width:100%">
                        <source src="${URL.createObjectURL(file)}" type="${file.type}">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
        `;

            // Show preview
            previewContainer.html(audioPreview);
            previewContainer.show();

            // Handle remove button click
            previewContainer.find('.remove-preview').click(function(e) {
                e.preventDefault();
                $(input).val(''); // Clear file input
                previewContainer.empty(); // Remove preview
            });
        } else {
            previewContainer.hide();
        }
    }

    $(document).ready(function() {
        // Initial binding for existing file inputs
        $('input[name="audio_file"], input[name="chapter_files[]"]').on('change', function() {
            handleAudioPreview(this);
        });

        // Update chapter addition to include preview handler
        $('#add-chapter').click(function() {
            const chapterCount = $('.chapter-entry').length + 1;
            const chapterHtml = `
            <div class="chapter-entry">
                <div class="form-group row">
                    <label class="col-md-3 control-label">Chapter ${chapterCount}</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control mb-2" 
                               name="chapter_titles[]" placeholder="Tên chapter">
                        <input type="file" class="form-control" 
                               name="chapter_files[]" accept="audio/*"
                               onchange="handleAudioPreview(this)">
                        <div class="audio-preview"></div>
                    </div>
                </div>
            </div>
        `;
            $('#chapters-container').append(chapterHtml);
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        //-initialize the javascript
        urlaudio();
        selectMenu('{{$menu}}');
    });
</script>
</body>

</html>
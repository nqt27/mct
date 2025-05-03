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
                                        <input type="checkbox" class="status-checkbox" data-switch="success" name="is_series" id="is_series">
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
                                        <input class="form-control" type="text" required="" placeholder="Đường dẫn" name="slug" id="audio-url">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">Tên audio</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" required="" placeholder="Tên audio" name="ten" id="name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">Tóm tắt</label>
                                    <div class="col-md-9">
                                        <textarea id="editor1" class="summernote" name="tomtat"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">Tác giả</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" required="" placeholder="Tác giả" name="tacgia" id="tacgia">
                                    </div>
                                </div>
                                <div class="form-group row pt-1">
                                    <label class="col-md-3 control-label">Danh mục cấp 1</label>
                                    <div class="col-md-9">
                                        <select class="form-control" id="select-parent" name="menu_id">
                                            <option value="">Chọn danh mục</option>
                                            @foreach($menu as $m)
                                            @if(is_null($m->parent_id))
                                            <option value="{{$m->id}}">{{$m->ten}}</option>

                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row pt-1">
                                    <label class="col-md-3 control-label">Danh mục cấp 2</label>
                                    <div class="col-md-9">
                                        <select class="form-control" id="select-child" name="menu_id2">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row pt-1">
                                    <label class="col-md-3 control-label">Danh mục cấp 3</label>
                                    <div class="col-md-9">
                                        <select class="form-control" id="select-subchild" name="menu_id3">
                                        </select>
                                    </div>
                                </div>

                                <!-- Single Audio File Upload -->
                                <div class="form-group row single-audio">
                                    <label class="col-md-3 control-label">File Audio</label>
                                    <div class="col-md-9">
                                        <input type="file" class="form-control" name="audio_file" accept="audio/*">
                                        <div class="audio-preview"></div>
                                    </div>
                                </div>

                                <!-- Series Chapters -->
                                <div class="series-chapters" style="display:none">
                                    <div id="chapters-container">
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
                                        <input class="form-control" type="text" placeholder="Keywword chính" id="keyword_focus" name="keyword_focus">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">SEO Title:</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" placeholder="SEO Title" name="seo_title" id="seo_title">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">SEO Keywords:</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" placeholder="SEO Keywords" name="seo_keywords">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">SEO Description:</label>
                                    <div class="col-md-9">
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
                                        <input type="checkbox" class="status-checkbox" data-switch="success" checked name="moi" id="moi">
                                        <label for="moi" data-on-label="Yes" data-off-label="No"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" style="justify-content: space-between; align-items: center;">
                                <label style="padding: 0" class="col-12 col-sm-3 col-form-label"><strong>Nghe nhiều</strong></label>
                                <div style="padding: 0" class="col-12 col-sm-8 col-lg-6">
                                    <div class="switch-button switch-button-success switch-button-xs">
                                        <input type="checkbox" class="status-checkbox" data-switch="success" checked name="nghenhieu" id="nghenhieu">
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
    // Disable auto discover for all elements
    Dropzone.autoDiscover = false;

    // Declare myDropzone in global scope
    var myDropzone;

    $(document).ready(function() {
        $(document).ready(function() {
            // Handle parent category change
            $('#select-parent').on('change', function() {
                const parentId = $(this).val();
                const childSelect = $('#select-child');
                const subChildSelect = $('#select-subchild'); // Get the sub-child select

                // Clear existing options
                childSelect.empty();
                childSelect.append('<option value="">Chọn danh mục</option>');
                subChildSelect.empty(); // Clear sub-child options
                subChildSelect.append('<option value="">Chọn danh mục</option>'); // Add default option for sub-child
                subChildSelect.prop('disabled', true); // Disable sub-child initially

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

            // Handle child category change to load sub-child categories
            $('#select-child').on('change', function() {
                const childId = $(this).val();
                const subChildSelect = $('#select-subchild');

                // Clear existing sub-child options
                subChildSelect.empty();
                subChildSelect.append('<option value="">Chọn thể loại con</option>');

                if (childId) {
                    // Get sub-subcategories via AJAX (using the same route, assuming it handles any parent_id)
                    $.ajax({
                        url: '/admin/get-subcategories/' + childId, // Use childId to fetch its children
                        method: 'GET',
                        success: function(response) {
                            if (response.subcategories && response.subcategories.length > 0) {
                                response.subcategories.forEach(function(subcategory) {
                                    subChildSelect.append(`<option value="${subcategory.id}">${subcategory.ten}</option>`);
                                });
                                subChildSelect.prop('disabled', false); // Enable sub-child select
                            } else {
                                subChildSelect.prop('disabled', true); // Disable if no sub-children
                            }
                        },
                        error: function() {
                            subChildSelect.prop('disabled', true);
                        }
                    });
                } else {
                    subChildSelect.prop('disabled', true); // Disable if no child is selected
                }

            });
        });

        // Initialize dropzone
        myDropzone = new Dropzone("#my-dropzone", {
            maxFiles: 1,
            autoProcessQueue: false,
            paramName: "image",
            uploadMultiple: false,
            previewsContainer: "#custom-preview",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            init: function() {
                this.on("addedfile", function(file) {
                    // Clear old preview
                    var previewContainer = document.getElementById("custom-preview");
                    previewContainer.innerHTML = "";

                    // Create new preview image
                    var previewImage = document.createElement("img");
                    previewImage.src = URL.createObjectURL(file);
                    previewImage.alt = file.name;
                    previewImage.className = "custom-preview-image";

                    // Add new preview
                    previewContainer.appendChild(previewImage);

                    // Remove old file if exists
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
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

        // Form submission handler
        $('#submit-all').on('click', function(e) {
            e.preventDefault();

            // Create FormData object
            var formData = new FormData($('#audio-info-form')[0]);

            // Add SEO form data
            $('#audio-seo-form').find('input, select, textarea').each(function() {
                formData.append(this.name, $(this).val());
            });

            // Add status checkboxes
            $('#audio-status-form').find('input[type="checkbox"]').each(function() {
                formData.append(this.name, $(this).is(':checked') ? 1 : 0);
            });

            // Add main image if exists
            if (myDropzone.files.length > 0) {
                formData.append("image", myDropzone.files[0]);
            }

            // Add series/chapters data
            formData.append('is_series', $('#is_series').is(':checked') ? 1 : 0);
            if ($('#is_series').is(':checked')) {
                $('.chapter-entry').each(function(index) {
                    const title = $(this).find('input[name="chapter_titles[]"]').val();
                    const file = $(this).find('input[name="chapter_files[]"]')[0].files[0];

                    if (title) formData.append(`chapter_titles[${index}]`, title);
                    if (file) formData.append(`chapter_files[${index}]`, file);
                });
            }

            // Send AJAX request
            $.ajax({
                url: "{{ route('audio.store') }}",
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
                        text: 'Audio đã được thêm thành công',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = "{{ route('audio.index') }}";
                    });
                },
                error: function(xhr) {
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

        // Initialize other features
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

<!-- Add this CSS to your existing styles or in a style tag -->
<style>
    .audio-preview {
        display: none;
    }

    .audio-preview .card {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
    }

    .audio-preview audio {
        outline: none;
    }

    .audio-preview audio::-webkit-media-controls-panel {
        background-color: #ffffff;
    }

    .remove-preview {
        padding: 0.25rem 0.5rem;
    }
</style>
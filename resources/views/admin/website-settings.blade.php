@include('admin/layout-header')

<div class="content-page">
    <div class="content">
        <div class="main-content container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Cài đặt nội dung website</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-border-color card-border-color-primary">
                        <div class="card-body" style="flex-direction: row; justify-content: normal">
                            <button class="btn btn-primary waves-effect waves-light" id="submit-all">
                                <i class="fas fa-save mr-1"></i><span>Lưu</span>
                            </button>
                            <a href="{{route('admin')}}" class="btn btn-secondary waves-effect waves-light" type="button">
                                <span>Trở về</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Google Analytics Section -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-border-color card-border-color-primary">
                        <div class="card-header bg-primary">
                            <h3 class="card-title text-white mb-0">Google Analytics</h3>
                        </div>
                        <div class="card-body">
                            <form id="analytics-form" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="analytics_code">Mã theo dõi Google Analytics (G-XXXXXXXXXX)</label>
                                    <input type="text"
                                        class="form-control"
                                        id="analytics_code"
                                        name="analytics_code"
                                        placeholder="Nhập mã G-XXXXXXXXXX"
                                        value="{{ $settings->analytics_code ?? '' }}">
                                    <small class="form-text text-muted">
                                        Nhập mã theo dõi Google Analytics của bạn (định dạng G-XXXXXXXXXX)
                                    </small>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="analytics_script" class="d-flex align-items-center mb-2">
                                        <i class="mdi mdi-code-tags me-2"></i>
                                        <span>Google Analytics Script</span>
                                        <button type="button" class="btn btn-sm btn-light ms-auto format-code">
                                            <i class="mdi mdi-format-align-left me-1"></i>Format Code
                                        </button>
                                    </label>
                                    <div class="code-editor-wrapper">
                                        <div class="code-editor-header bg-light border-bottom px-3 py-2">
                                            <small class="text-muted">script.js</small>
                                        </div>
                                        <textarea class="form-control code-editor"
                                            id="analytics_script"
                                            name="analytics_script"
                                            rows="10"
                                            spellcheck="false"
                                            placeholder="<!-- Paste your Google Analytics code here -->">{{ $settings->analytics_script ?? '' }}</textarea>
                                        <div class="code-editor-footer d-flex align-items-center bg-light border-top px-3 py-2">
                                            <small class="text-muted">
                                                <i class="mdi mdi-information-outline me-1"></i>
                                                Dán mã Global Site Tag (gtag.js) từ Google Analytics
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Content Section -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-border-color card-border-color-primary">
                        <div class="card-header bg-info">
                            <h3 class="card-title text-white mb-0">Nội dung Footer</h3>
                        </div>
                        <div class="card-body">
                            <form id="settings-form" method="post">
                                @csrf
                                <div class="form-group">
                                    <textarea id="editor1" class="summernote" name="content">{{ $settings->content ?? '' }}</textarea>
                                </div>
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

    .code-editor-wrapper {
        border: 1px solid #e5e9f2;
        border-radius: 6px;
        background: #1e1e1e;
    }

    .code-editor {
        font-family: 'Consolas', 'Monaco', 'Menlo', monospace;
        font-size: 14px;
        line-height: 1.6;
        color: #e6e6e6;
        background: #1e1e1e;
        padding: 15px;
        border: none;
        border-radius: 0;
        resize: vertical;
        min-height: 200px;
    }

    .code-editor:focus {
        outline: none;
        box-shadow: none;
        background: #1e1e1e;
        color: #e6e6e6;
    }

    .code-editor-header,
    .code-editor-footer {
        color: #6c757d;
        font-size: 12px;
    }

    .code-editor::placeholder {
        color: #666;
    }

    .format-code {
        font-size: 12px;
        padding: 3px 8px;
    }

    .code-editor::selection {
        background: rgba(255, 255, 255, 0.1);
    }

    .code-editor-wrapper:focus-within {
        border-color: #727cf5;
        box-shadow: 0 0 0 0.15rem rgba(114, 124, 245, .25);
    }
</style>
<!-- Vendor js -->
<script src="{{asset('assets\js\vendor.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('assets\js\app.min.js')}}"></script>
<script src="//cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>

<script>
    $(document).ready(function() {
        // Replace Summernote with CKEditor
        CKEDITOR.replace('editor1', {
            height: 500,
            fullPage: false,
            allowedContent: true,
            entities: false,
            removePlugins: 'elementspath,resize',
            language: 'vi',
            filebrowserUploadUrl: '/admin/upload-image',
            filebrowserUploadMethod: 'form'
        });

        // Update form submission to use CKEditor
        $('#submit-all').on('click', function(e) {
            e.preventDefault();

            var formData = new FormData($('#settings-form')[0]);
            formData.set('content', CKEDITOR.instances.editor1.getData());

            // Add analytics data
            formData.append('analytics_code', $('#analytics_code').val());
            formData.append('analytics_script', $('#analytics_script').val());

            $.ajax({
                url: '/admin/settings',
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
                        text: 'Cài đặt đã được cập nhật',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Lỗi!',
                        text: 'Không thể cập nhật cài đặt',
                        icon: 'error'
                    });
                }
            });
        });

        // Validate Analytics Code
        $('#analytics_code').on('input', function() {
            let value = $(this).val();
            if (value && !value.match(/^G-[A-Z0-9]{10}$/)) {
                $(this).addClass('is-invalid');
                $(this).next('.form-text').addClass('text-danger')
                    .text('Mã không đúng định dạng (G-XXXXXXXXXX)');
            } else {
                $(this).removeClass('is-invalid');
                $(this).next('.form-text').removeClass('text-danger')
                    .text('Nhập mã theo dõi Google Analytics của bạn (định dạng G-XXXXXXXXXX)');
            }
        });

        // Add to your existing script section
        $('.format-code').click(function() {
            const textarea = $('#analytics_script');
            let code = textarea.val();
            try {
                // Basic HTML/JavaScript formatting
                code = code.replace(/></g, '>\n<');
                code = code.replace(/\{/g, '{\n');
                code = code.replace(/\}/g, '\n}');
                code = code.replace(/;(?!\n)/g, ';\n');
                code = code.split('\n').map(line => line.trim()).join('\n');
                code = code.replace(/\n{3,}/g, '\n\n');

                // Add indentation
                let indent = 0;
                code = code.split('\n').map(line => {
                    if (line.includes('}')) indent--;
                    const spaces = '  '.repeat(Math.max(0, indent));
                    if (line.includes('{')) indent++;
                    return spaces + line;
                }).join('\n');

                textarea.val(code);
            } catch (e) {
                console.error('Error formatting code:', e);
            }
        });

        // Enable tab key in textarea
        $('#analytics_script').on('keydown', function(e) {
            if (e.key === 'Tab') {
                e.preventDefault();
                const start = this.selectionStart;
                const end = this.selectionEnd;
                const spaces = '  ';
                this.value = this.value.substring(0, start) + spaces + this.value.substring(end);
                this.selectionStart = this.selectionEnd = start + 2;
            }
        });

        // Line numbers (optional enhancement)
        $('#analytics_script').on('input scroll', function() {
            const lines = $(this).val().split('\n').length;
            // Update line numbers if you add them
        });
    });
</script>
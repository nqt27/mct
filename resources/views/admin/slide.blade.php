@include('admin/layout-header')

<div class="content-page">
    <div class="content">

        <div class="main-content container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Slideshow</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-header">
                            <a href="{{route('slide.add')}}" class="btn btn-space btn-primary" id="btn-add-audio"><i class="fas fa-plus mr-1"></i><span>Thêm mới</span></a>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered dt-responsive nowrap" id="table1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="select-all"></th>
                                        <th>STT</th>
                                        <th>Tiêu đề</th>
                                        <th>Hình ảnh</th>
                                        <th>Link</th>
                                        <th>Trạng thái</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($slide as $s)
                                    <tr class="odd gradeX a">
                                        <td style="width: 0%;"><input type="checkbox" class="select-item" value="{{ $s->id }}"></td>
                                        <td style="width: 0%;">{{$s->position}}</td>
                                        <td class="col-2">{{$s->title}}</td>
                                        <td class="col-1"><img src="{{asset('uploads/images/'. $s->filename)}}" style="width: 100%" alt=""></td>
                                        <td class="col-2">{{$s->title}}</td>
                                        <td class="col-1 audio-status" data-audio-id="{{ $s->id }}">
                                            <div class="form-group" style="justify-content: space-between; align-items: center;">
                                                <label style="padding: 0" class="col-12 col-sm-3 col-form-label"><strong>Hiển thị</strong></label>
                                                <div style="padding: 0" class="col-12 col-sm-8 col-lg-6">
                                                    <div class="switch-button switch-button-success switch-button-xs">
                                                        <input type="checkbox" class="status-checkbox" data-switch="success" {{ $s->display ? 'checked' : '' }} name="display" id="display{{$s->id}}">
                                                        <label for="display{{$s->id}}" data-on-label="Yes" data-off-label="No"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="center col-1">
                                            <div class="col-12">
                                                <button class="btn btn-space btn-danger delete-btn" data-id="{{ $s->id }}" type="submit" style="width: 100%;margin: 5px;"><i class="fas fa-trash mr-1"></i><span>Xóa</span></button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
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
<script src="{{asset('assets\js\app.min.js')}}" type="text/javascript"></script>

<!-- Datatable plugin js -->
<script src="{{asset('assets\libs\datatables\jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets\libs\datatables\dataTables.bootstrap4.min.js')}}"></script>

<script src="{{asset('assets\libs\datatables\dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets\libs\datatables\responsive.bootstrap4.min.js')}}"></script>

<script src="{{asset('assets\libs\datatables\dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets\libs\datatables\buttons.bootstrap4.min.js')}}"></script>

<script src="{{asset('assets\libs\datatables\buttons.html5.min.js')}}"></script>
<script src="{{asset('assets\libs\datatables\buttons.print.min.js')}}"></script>

<script src="{{asset('assets\libs\datatables\dataTables.keyTable.min.js')}}"></script>
<script src="{{asset('assets\libs\datatables\dataTables.fixedHeader.min.js')}}"></script>
<script src="{{asset('assets\libs\datatables\dataTables.scroller.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables/dataTables.fixedColumns.min.js')}}"></script>

<script src="{{asset('assets\libs\jszip\jszip.min.js')}}"></script>
<script src="{{asset('assets\libs\pdfmake\pdfmake.min.js')}}"></script>
<script src="{{asset('assets\libs\pdfmake\vfs_fonts.js')}}"></script>
<script src="{{asset('js\feature.js')}}" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<script type="text/javascript">
    $(document).ready(function() {
        //-initialize the javascript
        var table = $('#table1').DataTable({
            columnDefs: [{
                    orderable: false,
                    targets: [0, 1, 3, 4, 5, 6]
                } // Chỉ định các cột không sắp xếp, theo chỉ mục (bắt đầu từ 0)
            ]
        });
        statusAudio('/admin/slide-status/');
        deleteItem('/admin/slide/');
        // deleteAll('/admin/delete-all');
    });
</script>
</body>

</html>
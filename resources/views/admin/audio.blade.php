@include('admin/layout-header')

<div class="content-page">
    <div class="content">

        <div class="main-content container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Audio</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-header">
                            <a href="{{route('audio.add')}}" class="btn btn-space btn-primary" id="btn-add-audio"><i class="fas fa-plus mr-1"></i><span>Thêm mới</span></a>
                            <button class="btn btn-space btn-danger" id="delete-all"><i class="fas fa-trash mr-1"></i><span>Xóa tất cả</span></button>
                        </div>



                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <div class="form-group row px-5">
                                        <label class="col-12 col-sm-2" style="display: flex; align-items: center;">Danh mục cấp 1:</label>
                                        <div class="col-12 col-sm-8 col-lg-3">
                                            <select class="form-control" id="select-parent" name="category_level_1">
                                                <option value="All">Tất cả</option>
                                                @foreach($selectmenu as $m)
                                                <option value="{{$m->id}}">{{$m->ten}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row px-5">
                                        <label class="col-12 col-sm-2" style="display: flex; align-items: center;">Danh mục cấp 2</label>
                                        <div class="col-12 col-sm-8 col-lg-3">
                                            <select class="form-control select2" id="select-child" name="category_level_1">

                                            </select>
                                        </div>
                                    </div>

                                    <table class="table table-striped table-bordered dt-responsive nowrap" id="table1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="select-all"></th>
                                                <th>ID</th>
                                                <th>Tên Audio</th>
                                                <th>Hình ảnh</th>
                                                <th>Tác giả</th>
                                                <th>Danh mục</th>
                                                <th>Trạng thái</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($audio as $a)
                                            <tr class="odd gradeX a">
                                                <td style="width: 0%;"><input type="checkbox" class="select-item" value="{{ $a->id }}"></td>
                                                <td style="width: 0%;">{{$a->id}}</td>
                                                <td class="col-2">{{$a->ten}}</td>
                                                <td class="col-1"><img src="{{asset('uploads/images/'. $a->image)}}" style="width: 100%" alt=""></td>
                                                <td class="col-1">{{$a->tacgia}}</td>
                                                <td class="col-1 hidden-menu">
                                                    @foreach($menu as $m)
                                                    @if($a->menu_id == $m->id)
                                                    <span style="display: none;">{{$m->id}}</span>
                                                    {{$m->name}}
                                                    @endif
                                                    @endforeach
                                                </td>
                                                <td class="col-1 audio-status" data-audio-id="{{ $a->id }}">
                                                    <div class="form-group" style="justify-content: space-between; align-items: center;">
                                                        <label style="padding: 0" class="col-12 col-sm-3 col-form-label"><strong>Hiển thị</strong></label>
                                                        <div style="padding: 0" class="col-12 col-sm-8 col-lg-6">
                                                            <div class="switch-button switch-button-success switch-button-xs">
                                                                <input type="checkbox" class="status-checkbox" data-switch="success" {{ $a->display ? 'checked' : '' }} name="display" id="display{{$a->id}}">
                                                                <label for="display{{$a->id}}" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group" style="justify-content: space-between; align-items: center;">
                                                        <label style="padding: 0" class="col-12 col-sm-3 col-form-label"><strong>Nghe nhiều</strong></label>
                                                        <di style="padding: 0" class="col-12 col-sm-8 col-lg-6">
                                                            <div class="switch-button switch-button-success switch-button-xs">
                                                                <input type="checkbox" class="status-checkbox" data-switch="success" {{ $a->nghenhieu ? 'checked' : '' }} name="nghenhieu" id="hot{{$a->id}}">
                                                                <label for="hot{{$a->id}}" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </di>
                                                    </div>
                                                    <div class="form-group" style="justify-content: space-between; align-items: center;">
                                                        <label style="padding: 0" class="col-12 col-sm-3 col-form-label"><strong>Mới</strong></label>
                                                        <di style="padding: 0" class="col-12 col-sm-8 col-lg-6">
                                                            <div class="switch-button switch-button-success switch-button-xs">
                                                                <input type="checkbox" class="status-checkbox" data-switch="success" {{ $a->moi ? 'checked' : '' }} name="moi" id="moi{{$a->id}}">
                                                                <label for="moi{{$a->id}}" data-on-label="Yes" data-off-label="No"></label>
                                                            </div>
                                                        </di>
                                                    </div>

                                                </td>

                                                <td class="center col-1">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <a href="/admin/audio-detail/{{$a->id}}" class="btn btn-space btn-info" id="btn-add-audio" style="width: 100%;margin: 5px;"><i class="fas fa-edit mr-1"></i><span>Chỉnh sửa</span></a>
                                                        </div>
                                                        <div class="col-12">
                                                            <button class="btn btn-space btn-danger delete-btn" data-id="{{ $a->id }}" type="submit" style="width: 100%;margin: 5px;"><i class="fas fa-trash mr-1"></i><span>Xóa</span></button>
                                                        </div>
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
</div>
@include('admin/layout-footer')
<!-- <script src="{{asset('assets\lib\jquery\jquery.min.js')}}" type="text/javascript"></script> -->
<!-- <script src="{{asset('assets\lib\perfect-scrollbar\js\perfect-scrollbar.min.js')}}" type="text/javascript"></script> -->
<!-- <script src="{{asset('assets\lib\bootstrap\dist\js\bootstrap.bundle.min.js')}}" type="text/javascript"></script> -->
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
        selectMenu()
        table('{{$selectmenu}}', [0, 3, 4, 5, 6, 7]);
        statusAudio('/admin/audio-status/');
        deleteItem('/admin/audio/');
        deleteAll('/admin/delete-all');
    });
</script>




</body>

</html>
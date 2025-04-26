@include('admin/layout-header')

<div class="content-page">
    <div class="content">


        <div class="main-content container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Danh mục con của {{$menu->name}}</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-12">
                    <div id="column-1">
                        <div class="card">
                            <div class="card-header card-header-divider">
                                <button class="btn btn-space btn-primary" id="btn-add-submenu"><i class="icon icon-left mdi mdi-plus-circle"></i><span>Thêm menu</span></button>
                            </div>

                        </div>
                        @foreach($submenu as $m)
                        <div class="card menu-item" id="menu-{{$m->id}}">
                            <div class="card-header card-header-divider">{{$m->name}}
                                <!-- <a href="/admin/submenu-review/{{$m->id}}" class="btn btn-info waves-effect waves-light btn-submenu" data-id="{{$m->id}}" data-name="{{$m->name}}" data-url="{{$m->url}}" type="button" style="float: right; margin:5px"><i class="fas fa-list mr-1"></i><span>Danh mục con</span></a> -->
                                <button class="btn btn-success waves-effect waves-light edit-btn" data-id="{{$m->id}}" data-name="{{$m->name}}" data-url="{{$m->url}}" type="button" style="float: right; margin:5px"><i class="fas fa-edit mr-1"></i><span>Sửa danh mục</span></button>
                                <button class="btn btn-space btn-danger delete-btn" data-id="{{$m->id}}" data-name="{{$m->name}}" data-url="{{$m->url}}" type="button" style="float: right; margin:5px"><i class="fas fa-trash mr-1"></i><span>Xóa danh mục</span></button>

                            </div>

                        </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@include('admin/layout-footer')


<!-- Vendor js -->
<script src="{{asset('assets\js\vendor.min.js')}}"></script>
<!-- <script src="{{asset('assets\lib\jquery\jquery.min.js')}}" type="text/javascript"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="{{asset('assets\lib\perfect-scrollbar\js\perfect-scrollbar.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets\lib\bootstrap\dist\js\bootstrap.bundle.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets\lib\jquery.nestable\jquery.nestable.js')}}" type="text/javascript"></script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('assets\js\app.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js\feature.js')}}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.3/dragula.min.js"></script>




<script type="text/javascript">
    $(document).ready(function() {
        drag('/admin/updateOrder-review');
        addMenu($('#btn-add-submenu'), '/admin/addsubmenu-review', 'POST', '{{$menu->id}}');
        editMenu($('.edit-btn'), `/admin/menu-review`);
        deleteMenu(`/admin/menu-review`);
    });
</script>
</body>

</html>
@include('admin/layout-header')

<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Thông báo</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Tất cả thông báo</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @if($notifications->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-centered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nội dung</th>
                                            <th>Loại</th>
                                            <th>Thời gian</th>
                                            <th>Trạng thái</th>
                                            <th style="width: 82px;">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($notifications as $notification)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="notify-icon 
                                                            @if($notification->data['type'] === 'contact')
                                                                bg-info
                                                            @elseif($notification->data['type'] === 'order')
                                                                bg-success
                                                            @else
                                                                bg-primary
                                                            @endif
                                                        ">
                                                            @if($notification->data['type'] === 'contact')
                                                            <i class="mdi mdi-message-text"></i>
                                                            @elseif($notification->data['type'] === 'order')
                                                            <i class="mdi mdi-cart-outline"></i>
                                                            @else
                                                            <i class="mdi mdi-bell-outline"></i>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h5 class="font-14 my-1">
                                                            <a href="{{ route('notifications.show', $notification->id) }}" class="text-reset">
                                                                {{ $notification->data['message'] ?? 'Thông báo mới' }}
                                                            </a>
                                                        </h5>
                                                        <small class="text-muted">
                                                            @if($notification->data['type'] === 'contact')
                                                            {{ $notification->data['name'] ?? '' }} - {{ $notification->data['email'] ?? '' }}
                                                            @elseif($notification->data['type'] === 'order')
                                                            {{ $notification->data['first_name'] ?? '' }} {{ $notification->data['last_name'] ?? '' }}
                                                            @endif
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge 
                                                    @if($notification->data['type'] === 'contact')
                                                        bg-info
                                                    @elseif($notification->data['type'] === 'order')
                                                        bg-success
                                                    @else
                                                        bg-primary
                                                    @endif
                                                ">
                                                    @if($notification->data['type'] === 'contact')
                                                    Liên hệ
                                                    @elseif($notification->data['type'] === 'order')
                                                    Đơn hàng
                                                    @else
                                                    Khác
                                                    @endif
                                                </span>
                                            </td>
                                            <td>
                                                <span class="font-12">{{ $notification->created_at->format('H:i, d/m/Y') }}</span>
                                                <p class="mb-0 text-muted"><small>{{ $notification->created_at->diffForHumans() }}</small></p>
                                            </td>
                                            <td>
                                                @if($notification->read_at)
                                                <span class="badge bg-light text-dark">Đã đọc</span>
                                                @else
                                                <span class="badge bg-primary">Chưa đọc</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('notifications.show', $notification->id) }}" class="action-icon">
                                                    <i class="mdi mdi-eye"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="action-icon delete-notification" data-id="{{ $notification->id }}">
                                                    <i class="mdi mdi-delete"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @else
                            <div class="text-center p-4">
                                <p>Không có thông báo nào</p>
                            </div>
                            @endif
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
<script src="{{asset('assets\js\app.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js\feature.js')}}" type="text/javascript"></script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>




<script>
    $(document).ready(function() {
        // Xử lý xóa thông báo
        $('.delete-notification').click(function() {
            var id = $(this).data('id');
            var row = $(this).closest('tr');

            Swal.fire({
                title: 'Bạn có chắc chắn?',
                text: "Thông báo này sẽ bị xóa vĩnh viễn!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/notifications/' + id,
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            row.remove();
                            Swal.fire('Đã xóa!', 'Thông báo đã được xóa.', 'success');
                        }
                    });
                }
            });
        });
    });
</script>
</body>

</html>
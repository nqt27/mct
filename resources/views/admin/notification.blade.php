@include('admin/layout-header')

<div class="content-page">
    <div class="content">
        <div class="main-content container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">{{ $notification->data['message']}}</h4>
                        <a href="{{ route('admin') }}" class="btn btn-light">
                            <i class="mdi mdi-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
            </div>
            @if($notification->data['type'] === 'order')
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <i class="mdi mdi-cart me-2"></i>
                                Thông tin đơn hàng mới
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="notification-info">
                                <!-- Thời gian -->
                                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                    <i class="mdi mdi-calendar-clock text-primary me-2 font-size-18"></i>
                                    <div>
                                        <small class="text-muted">Thời gian đặt hàng</small>
                                        <p class="mb-0 font-size-14">{{ $notification->created_at->format('H:i, d/m/Y') }}</p>
                                    </div>
                                </div>

                                <!-- Thông tin khách hàng -->
                                <div class="customer-info mb-4">
                                    <h6 class="text-muted mb-3">Thông tin khách hàng:</h6>
                                    <div class="p-3 bg-light rounded">
                                        <p><strong>Họ tên:</strong> {{ $notification->data['first_name'] }} {{ $notification->data['last_name'] }}</p>
                                        <p><strong>Email:</strong> {{ $notification->data['email'] }}</p>
                                        <p><strong>Số điện thoại:</strong> {{ $notification->data['phone'] }}</p>
                                        <p><strong>Địa chỉ:</strong> {{ $notification->data['address'] }}</p>
                                        <p class="mb-0"><strong>Phương thức thanh toán:</strong>
                                            @if($notification->data['payment_method'] == 'cod')
                                            Thanh toán khi nhận hàng (COD)
                                            @else
                                            Thanh toán QR Code
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <!-- Giỏ hàng -->
                                @if(isset($notification->data['cart']))
                                <div class="cart-details p-3 bg-light rounded mb-4">
                                    <h6 class="text-primary mb-3">
                                        <i class="mdi mdi-cart me-2"></i>Chi tiết đơn hàng
                                    </h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Sản phẩm</th>
                                                    <th>SKU</th>
                                                    <th>Thuộc tính</th>
                                                    <th>Số lượng</th>
                                                    <th>Đơn giá</th>
                                                    <th>Thành tiền</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($notification->data['cart'] as $item)
                                                <tr>
                                                    <td>{{ $item['name'] }}</td>
                                                    <td>{{ $item['sku'] }}</td>
                                                    <td>
                                                        @if(isset($item['variant']))
                                                        @foreach($item['variant'] as $attr => $values)
                                                        <p class="mb-0">
                                                            <strong>{{ $attr }}:</strong> {{ $values['value'] }}
                                                        </p>
                                                        @endforeach
                                                        @endif
                                                    </td>
                                                    <td>{{ $item['quantity'] }}</td>
                                                    <td>{{ number_format($item['price']) }}đ</td>
                                                    <td>{{ number_format($item['price'] * $item['quantity']) }}đ</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5" class="text-end"><strong>Tổng cộng:</strong></td>
                                                    <td><strong>{{ number_format(array_sum(array_map(function($item) {
                                                        return $item['price'] * $item['quantity'];
                                                    }, $notification->data['cart']))) }}đ</strong></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @elseif($notification->data['type'] === 'contact')
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <i class="mdi mdi-cart me-2"></i>
                                Thông tin liên hệ mới
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="notification-info">
                                <!-- Thời gian -->
                                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                    <i class="mdi mdi-calendar-clock text-primary me-2 font-size-18"></i>
                                    <div>
                                        <small class="text-muted">Thời gian</small>
                                        <p class="mb-0 font-size-14">{{ $notification->created_at->format('H:i, d/m/Y') }}</p>
                                    </div>
                                </div>

                                <!-- Thông tin khách hàng -->
                                <div class="customer-info mb-4">
                                    <h6 class="text-muted mb-3">Thông tin khách hàng:</h6>
                                    <div class="p-3 bg-light rounded">
                                        <p><strong>Họ tên:</strong> {{ $notification->data['name'] }}</p>
                                        <p><strong>Email:</strong> {{ $notification->data['email'] }}</p>
                                        <p><strong>Số điện thoại:</strong> {{ $notification->data['phone'] }}</p>
                                        <p><strong>Nội dung:</strong> {{ $notification->data['content'] }}</p>

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@include('admin/layout-footer')
<!-- Vendor js -->
<script src="{{asset('assets\js\vendor.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('assets\js\app.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js\feature.js')}}" type="text/javascript"></script>


<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script> -->



</body>

</html>
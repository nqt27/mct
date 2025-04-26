@include('admin/layout-header')

<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Bảng điều khiển</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h3 class="card-title text-white mb-0">Cấu hình dịch vụ</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-xl-3">
                                    <div class="card widget-box-three">
                                        <a href="{{route('profile.edit')}}" class="btn btn-success waves-effect waves-light btn-lg dashboard-btn"> <i class="fas fa-edit mr-1"></i> <span>Thay đổi thông tin Admin</span> </a>
                                    </div>
                                </div>

                                <!-- end col -->

                                <div class="col-lg-6 col-xl-3">
                                    <div class="card widget-box-three">
                                    <a href="{{route('web-config.index')}}" class="btn btn-teal waves-effect waves-light btn-lg dashboard-btn"> <i class="fas fa-edit mr-1"></i> <span>Cấu hình website</span> </a>
                                    </div>
                                </div>

                                <!-- end col -->
                                <div class="col-lg-6 col-xl-3">
                                    <div class="card widget-box-three">
                                    <a href="{{route('settings.index')}}" class="btn btn-orange waves-effect waves-light btn-lg dashboard-btn"> <i class="fas fa-edit mr-1"></i> <span>Cài đặt website</span> </a>
                                    </div>
                                </div>

                                <!-- end col -->
                                <div class="col-lg-6 col-xl-3">
                                    <div class="card widget-box-three">
                                        <button class="btn btn-pink waves-effect waves-light btn-lg dashboard-btn"> <i class="fas fa-cloud mr-1"></i> <span>Cloud Hosting</span> </button>
                                    </div>
                                </div>

                                <!-- end col -->
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-info">
                            <h3 class="card-title text-white mb-0">Thống kê truy cập</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @php
                                $todayStats = $dailyStats->last();
                                @endphp
                                <div class="col-lg-6 col-xl-3">
                                    <div class="card widget-box-three card-stat">
                                        <div class="card-body">
                                            <div class="float-right mt-2">
                                                <i class="mdi mdi-chart-areaspline display-3 m-0"></i>
                                            </div>
                                            <div class="overflow-hidden">
                                                <p class="text-uppercase font-weight-medium text-truncate mb-2">Trong ngày</p>
                                                <h2 class="mb-0"><span data-plugin="counterup">{{$todayStats->total_visits}}</span> <i class="mdi mdi-arrow-up text-success font-24"></i></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                                @php
                                $todayStats = $weeklyStats->last();
                                @endphp
                                <div class="col-lg-6 col-xl-3">
                                    <div class="card widget-box-three card-stat">
                                        <div class="card-body">
                                            <div class="float-right mt-2">
                                                <i class="mdi mdi-chart-areaspline display-3 m-0"></i>
                                            </div>
                                            <div class="overflow-hidden">
                                                <p class="text-uppercase font-weight-medium text-truncate mb-2">Trong tuần</p>
                                                <h2 class="mb-0"><span data-plugin="counterup">{{$todayStats->total_visits}}</span> <i class="mdi mdi-arrow-up text-success font-24"></i></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                                @php
                                $todayStats = $monthlyStats->last();
                                @endphp
                                <div class="col-lg-6 col-xl-3">
                                    <div class="card widget-box-three card-stat">
                                        <div class="card-body">
                                            <div class="float-right mt-2">
                                                <i class="mdi mdi-chart-areaspline display-3 m-0"></i>
                                            </div>
                                            <div class="overflow-hidden">
                                                <p class="text-uppercase font-weight-medium text-truncate mb-2">Trong tháng</p>
                                                <h2 class="mb-0"><span data-plugin="counterup">{{$todayStats->total_visits}}</span> <i class="mdi mdi-arrow-up text-success font-24"></i></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->

                            </div>
                            <!-- end row -->
                            <div class="row">
                                <div class="col">

                                    <div class="demo-box">
                                        <h4 class="header-title">Biểu đồ </h4>
                                        <div class="col-lg-3">
                                            <select class="selectpicker" data-style="btn-info" id="chartSelector" title="charSelector">
                                                <option selected value="daily">Theo Ngày</option>
                                                <option value="weekly">Theo Tuần</option>
                                                <option value="monthly">Theo Tháng</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- end row -->


                                    <div id="morris-area-example" dir="ltr" class="morris-charts"></div>

                                </div>
                            </div>

                        </div>
                        <!-- end row -->
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
    </div>
    <!-- end container-fluid -->
</div>
<!-- end content -->





</div>

<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->




</div>
@include('admin/layout-footer')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Dữ liệu ngày, tuần, tháng từ Blade
        var dailyDates = <?php echo json_encode($dailyDates ?? []); ?>;
        var dailyVisits = <?php echo json_encode($dailyVisits ?? []); ?>;

        var weeklyDates = <?php echo json_encode($weeklyDates ?? []); ?>;
        var weeklyVisits = <?php echo json_encode($weeklyVisits ?? []); ?>;

        var monthlyDates = <?php echo json_encode($monthlyDates ?? []); ?>;
        var monthlyVisits = <?php echo json_encode($monthlyVisits ?? []); ?>;


        // Khởi tạo Morris Chart
        var chart = new Morris.Area({
            element: 'morris-area-example',
            data: [],
            xkey: 'y',
            ykeys: ['a'],
            labels: ['Số lượt truy cập'],
            lineColors: ['#d9534f'],
            fillOpacity: 0.6,
            behaveLikeLine: true,
            resize: true,
        });

        // Hàm cập nhật dữ liệu cho biểu đồ
        function updateChart(type) {
            let dates, visits;
            switch (type) {
                case 'daily':
                    dates = dailyDates;
                    visits = dailyVisits;
                    break;
                case 'weekly':
                    dates = weeklyDates;
                    visits = weeklyVisits;
                    break;
                case 'monthly':
                    dates = monthlyDates;
                    visits = monthlyVisits;
                    break;
            }
            // Cập nhật dữ liệu mới
            var formattedData = dates.map((date, index) => ({
                y: date,
                a: visits[index]
            }));
            chart.setData(formattedData);
        }

        // Sự kiện thay đổi select
        document.getElementById("chartSelector").addEventListener("change", function(e) {
            updateChart(e.target.value);
        });

        // Hiển thị biểu đồ mặc định (Theo Ngày)
        updateChart('daily');
    });
</script>



<!-- Vendor js -->
<script src="{{asset('assets\js\vendor.min.js')}}"></script>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<!-- Thêm Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Thêm Bootstrap Select JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
<script src="{{asset('assets\libs\morris-js\morris.min.js')}}"></script>
<script src="{{asset('assets\libs\raphael\raphael.min.js')}}"></script>

<!-- <script src="{{asset('assets\libs\bootstrap-select\bootstrap-select.min.js')}}"></script> -->
<!-- Thêm jQuery -->


<!-- App js -->
<script src="{{asset('assets\js\app.min.js')}}"></script>
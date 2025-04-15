@include('admin/layout-header')
<!-- Page Content -->
@vite(['resources/css/app.css', 'resources/js/app.js'])

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <main>
                {{ $slot }}
            </main>
        </div>
    </div>
</div>
<!-- Vendor js -->
<script src="{{asset('assets\js\vendor.min.js')}}"></script>

<!-- App js -->
<script src="{{asset('assets\js\app.min.js')}}"></script>
@include('admin/layout-footer')
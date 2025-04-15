<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('assets\images\favicon.ico')}}">
    <title>Admin</title>

    <!-- Thêm Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <!-- Thêm Bootstrap Select CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.3/dragula.min.css">
    <!-- Summernote css -->
    <link href="{{asset('assets\libs\summernote\summernote-bs4.css')}}" rel="stylesheet" type="text/css">
    <!-- Dropzone CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/min/dropzone.min.css" />

    <link href="{{asset('assets\libs\datatables\dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets\libs\datatables\responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets\libs\datatables\buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets\libs\datatables\fixedHeader.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets\libs\datatables\scroller.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets\libs\datatables\dataTables.colVis.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/libs/datatables/fixedColumns.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
    <!-- App css -->
    <link rel="stylesheet" href="{{asset('assets\css\bootstrap.min.css')}}" type="text/css" id="bootstrap-stylesheet">
    <link rel="stylesheet" href="{{asset('assets\css\icons.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/css/app.css')}}" type="text/css" id="app-stylesheet">
</head>

<body>
    <!-- Begin page -->
    <div id="wrapper">


        <!-- Topbar Start -->
        <div class="navbar-custom">
            <ul class="list-unstyled topnav-menu float-right mb-0">
                <li class="notification-list">
                    <a href="/" class="nav-link waves-effect">
                        <i class="mdi mdi-arrow-left noti-icon"></i>
                    </a>
                </li>
                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle  waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="mdi mdi-bell noti-icon"></i>
                        <span class="badge badge-success rounded-circle noti-icon-badge">4</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-lg">

                        <!-- item-->
                        <div class="dropdown-item noti-title">
                            <h5 class="font-16 m-0">
                                <span class="float-right">
                                    <a href="" class="text-dark">
                                        <small>Clear All</small>
                                    </a>
                                </span>Notification
                            </h5>
                        </div>

                        <div class="slimscroll noti-scroll">

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-success">
                                    <i class="mdi mdi-settings-outline"></i>
                                </div>
                                <p class="notify-details">New settings
                                    <small class="text-muted">There are new settings available</small>
                                </p>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-info">
                                    <i class="mdi mdi-bell-outline"></i>
                                </div>
                                <p class="notify-details">Updates
                                    <small class="text-muted">There are 2 new updates available</small>
                                </p>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-danger">
                                    <i class="mdi mdi-account-plus"></i>
                                </div>
                                <p class="notify-details">New user
                                    <small class="text-muted">You have 10 unread messages</small>
                                </p>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-info">
                                    <i class="mdi mdi-comment-account-outline"></i>
                                </div>
                                <p class="notify-details">Caleb Flakelar commented on Admin
                                    <small class="text-muted">4 days ago</small>
                                </p>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-secondary">
                                    <i class="mdi mdi-heart"></i>
                                </div>
                                <p class="notify-details">Carlos Crouch liked
                                    <b>Admin</b>
                                    <small class="text-muted">13 days ago</small>
                                </p>
                            </a>
                        </div>

                        <!-- All-->
                        <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                            See all Notification
                            <i class="fi-arrow-right"></i>
                        </a>

                    </div>
                </li>

                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle  waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="mdi mdi-email noti-icon"></i>
                        <span class="badge badge-danger rounded-circle noti-icon-badge">8</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-lg">

                        <!-- item-->
                        <div class="dropdown-item noti-title">
                            <h5 class="font-16 m-0">
                                <span class="float-right">
                                    <a href="" class="text-dark">
                                        <small>Clear All</small>
                                    </a>
                                </span>Messages
                            </h5>
                        </div>

                        <div class="slimscroll noti-scroll">

                            <div class="inbox-widget">
                                <a href="#">
                                    <div class="inbox-item">
                                        <div class="inbox-item-img"><img src="{{asset('assets\images\users\avatar-1.jpg')}}" class="rounded-circle" alt=""></div>
                                        <p class="inbox-item-author">Chadengle</p>
                                        <p class="inbox-item-text text-truncate">Hey! there I'm available...</p>
                                    </div>
                                </a>
                                <a href="#">
                                    <div class="inbox-item">
                                        <div class="inbox-item-img"><img src="{{asset('assets\images\users\avatar-2.jpg')}}" class="rounded-circle" alt=""></div>
                                        <p class="inbox-item-author">Tomaslau</p>
                                        <p class="inbox-item-text text-truncate">I've finished it! See you so...</p>
                                    </div>
                                </a>
                                <a href="#">
                                    <div class="inbox-item">
                                        <div class="inbox-item-img"><img src="{{asset('assets\images\users\avatar-3.jpg')}}" class="rounded-circle" alt=""></div>
                                        <p class="inbox-item-author">Stillnotdavid</p>
                                        <p class="inbox-item-text text-truncate">This theme is awesome!</p>
                                    </div>
                                </a>
                                <a href="#">
                                    <div class="inbox-item">
                                        <div class="inbox-item-img"><img src="{{asset('assets\images\users\avatar-4.jpg')}}" class="rounded-circle" alt=""></div>
                                        <p class="inbox-item-author">Kurafire</p>
                                        <p class="inbox-item-text text-truncate">Nice to meet you</p>
                                    </div>
                                </a>
                                <a href="#">
                                    <div class="inbox-item">
                                        <div class="inbox-item-img"><img src="{{asset('assets\images\users\avatar-5.jpg')}}" class="rounded-circle" alt=""></div>
                                        <p class="inbox-item-author">Shahedk</p>
                                        <p class="inbox-item-text text-truncate">Hey! there I'm available...</p>

                                    </div>
                                </a>
                            </div> <!-- end inbox-widget -->

                        </div>
                        <!-- All-->
                        <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                            See all Messages
                            <i class="fi-arrow-right"></i>
                        </a>

                    </div>
                </li>

                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="{{asset('assets\images\users\avatar-1.jpg')}}" alt="user-image" class="rounded-circle">
                        <span class="d-none d-sm-inline-block ml-1">Alex M.</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                        <!-- item-->
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome !</h6>
                        </div>

                        <!-- item-->
                        <a href="{{route('profile.edit')}}" class="dropdown-item notify-item">
                            <i class="mdi mdi-account-outline"></i>
                            <span>Thông tin</span>
                        </a>




                        <div class="dropdown-divider"></div>

                        <!-- item-->
                        @auth
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="icon mdi mdi-power"></i><span>Đăng xuất</span></a>
                        @endauth

                    </div>
                </li>

                <li class="dropdown notification-list">
                    <a href="javascript:void(0);" class="nav-link right-bar-toggle waves-effect">
                        <i class="mdi mdi-settings noti-icon"></i>
                    </a>
                </li>

            </ul>

            <!-- LOGO -->
            <div class="logo-box">
                <a href="{{route('admin')}}" class="logo text-center">
                    <span class="logo-lg">
                        <img src="{{asset('assets\images\logo-light.png')}}" alt="" height="18">
                        <!-- <span class="logo-lg-text-light">Zircos</span> -->
                    </span>
                    <span class="logo-sm">
                        <!-- <span class="logo-sm-text-dark">Z</span> -->
                        <img src="{{asset('assets\images\logo-sm.png')}}" alt="" height="24">
                    </span>
                </a>
            </div>

            <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                <li>
                    <button class="button-menu-mobile waves-effect" title="menu">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </li>

                <li class="d-none d-sm-block">
                    <form class="app-search">
                        <div class="app-search-box">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search...">
                                <div class="input-group-append">
                                    <button class="btn" type="submit" title="search">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </li>


            </ul>
        </div>
        <!-- end Topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        <div class="left-side-menu">

            <div class="slimscroll-menu">

                <!--- Sidemenu -->
                <div id="sidebar-menu">

                    <ul class="metismenu" id="side-menu">

                        <li class="menu-title">Navigation</li>

                        <li>
                            <a href="javascript: void(0);" class="waves-effect waves-light">
                                <i class="mdi mdi-view-dashboard"></i>
                                <span> Dashboard </span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="waves-effect waves-light">
                                <i class="mdi mdi-cart"></i>
                                <span> Audio </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">

                                <li><a href="{{route('audio.index')}}">Quản lý Audio</a></li>
                                <li><a href="{{route('menu.index')}}">Danh mục</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="waves-effect waves-light">
                                <i class="mdi mdi-file-document-box"></i>
                                <span> Bài viết </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li>
                                    <a href="{{route('dichvu.index')}}"></i>Dịch vụ</a>
                                </li>
                                <li>
                                    <a href="{{route('menu-dichvu.index')}}">Danh mục</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="waves-effect waves-light">
                                <i class="mdi mdi-layers"></i>
                                <span> SEO Page </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li><a href="{{route('seo')}}">Trang chủ</a></li>
                                <li><a href="{{route('seo')}}">Sản phẩm</a></li>
                                <li><a href="{{route('seo')}}">Giới thiệu</a></li>

                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="waves-effect waves-light">
                                <i class="mdi  mdi mdi-folder-multiple-image"></i>
                                <span> Hình ảnh-Video </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li><a href="{{route('logo')}}">Logo</a>
                                </li>
                                <li><a href="{{route('slide.index')}}">SlideShow</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="waves-effect waves-light">
                                <i class="mdi mdi-layers"></i>
                                <span> Quản lý trang </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li>
                                    <a href="{{route('dichvu.index')}}"></i>Bài viết</a>
                                </li>
                                <li>
                                    <a href="{{route('menu-dichvu.index')}}">Menu bài viết</a>
                                </li>
                            </ul>
                        </li>

                    </ul>

                </div>
                <!-- End Sidebar -->

                <div class="clearfix"></div>

                <div class="help-box">
                    <h5 class="text-muted mt-0">Liên hệ kỹ thuật</h5>
                    <p class=""><span class="text-info">Email:</span>
                        <br> nguyenduytandev021@gmail.com
                    </p>
                    <p class="mb-0"><span class="text-info">Call:</span>
                        <br> 0932126026
                    </p>
                </div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->



    </div>
    <!-- END wrapper -->

    <!-- Right Sidebar -->
    <div class="right-bar">
        <div class="rightbar-title">
            <a href="javascript:void(0);" class="right-bar-toggle float-right">
                <i class="mdi mdi-close"></i>
            </a>
            <h4 class="font-16 m-0 text-white">Theme Customizer</h4>
        </div>
        <div class="slimscroll-menu">

            <div class="p-4">
                <div class="alert alert-warning" role="alert">
                    <strong>Customize </strong> the overall color scheme, layout, etc.
                </div>
                <div class="mb-2">
                    <img src="{{asset('assets\images\layouts\light.png')}}" class="img-fluid img-thumbnail" alt="">
                </div>
                <div class="custom-control custom-switch mb-3">
                    <input type="checkbox" class="custom-control-input theme-choice" id="light-mode-switch" checked="">
                    <label class="custom-control-label" for="light-mode-switch">Light Mode</label>
                </div>

                <div class="mb-2">
                    <img src="{{asset('assets\images\layouts\dark.png')}}" class="img-fluid img-thumbnail" alt="">
                </div>
                <div class="custom-control custom-switch mb-3">
                    <input type="checkbox" class="custom-control-input theme-choice" id="dark-mode-switch" data-bsstyle="{{asset('assets/css/bootstrap-dark.min.css')}}" data-appstyle="{{asset('assets/css/app-dark.min.css')}}">
                    <label class="custom-control-label" for="dark-mode-switch">Dark Mode</label>
                </div>
            </div>
        </div> <!-- end slimscroll-menu-->
    </div>
    <!-- /Right-bar -->
    <!-- Vendor js -->
    <!-- <script src="{{asset('assets\js\vendor.min.js')}}"></script> -->


    <!-- App js -->
    <!-- <script src="{{asset('assets\js\app.min.js')}}"></script> -->
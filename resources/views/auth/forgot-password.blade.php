<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login | Snake - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Responsive bootstrap 4 admin template" name="description">
    <meta content="Coderthemes" name="author">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets\images\favicon.ico">

    <!-- App css -->
    <link rel="stylesheet" href="{{asset('assets\css\bootstrap.min.css')}}" type="text/css" id="bootstrap-stylesheet">
    <link rel="stylesheet" href="{{asset('assets\css\icons.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/css/app.css')}}" type="text/css" id="app-stylesheet">

</head>

<body>

    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">

                        <div class="text-center account-logo-box">
                            <div class="mt-2 mb-2">
                                <a href="index.html" class="text-success">
                                    <span><img src="assets\images\logo.png" alt="" height="36"></span>
                                </a>
                            </div>
                        </div>

                        <div class="card-body">

                            <div class="text-center mb-4">
                                <p class="text-muted mb-0">Enter your email address and we'll send you an email with instructions to reset your password. </p>
                            </div>
                            <x-auth-session-status class="mb-4" :status="session('status')" />
                            <form action="{{ route('password.email') }}">
                                <div class="form-group row">
                                    <div class="col-12">
                                        <input class="form-control" type="email" name="email" required="" placeholder="Enter email">
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="form-group account-btn text-center mt-2 row">
                                    <div class="col-12">
                                        <button class="btn width-md btn-bordered btn-danger waves-effect waves-light" type="submit">Send Email
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-5">
                        <div class="col-sm-12 text-center">
                            <p class="text-muted">Already have account?<a href="page-login.html" class="text-primary ml-1"><b>Sign In</b></a></p>
                        </div>
                    </div>
                </div>

            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->

    <!-- Vendor js -->
    <script src="{{asset('assets\js\vendor.min.js')}}"></script>

    <!-- App js -->
    <script src="{{asset('assets\js\app.min.js')}}"></script>

</body>

</html>

<!-- <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form> -->
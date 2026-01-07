<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Adnan Mobiles | Reset Password</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('uploads/c2.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('newdash/assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('newdash/assets/vendor/css/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('newdash/assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('newdash/assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('newdash/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('newdash/assets/vendor/css/pages/page-auth.css') }}" />
    <script src="{{ asset('newdash/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('newdash/assets/js/config.js') }}"></script>

</head>

<body>
    <!-- Content -->

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Forgot Password -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="{{ url('/admin') }}" class="app-brand-link gap-2">
                                <img src="{{ asset('uploads/c2.png') }}" style="width:100%" height="150px" alt="">
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">Reset Password? 🔒</h4>

                        <form id="formAuthentication" class="mb-3" action="{{ route('password.update') }}"
                            method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>

                                <input
                                id="email"
                                type="email"
                                placeholder="Enter your email"
                                class="form-control @error('email') is-invalid @enderror"
                                name="email"
                                value="{{ $email ?? old('email') }}"
                                required
                                autocomplete="email"
                                autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <label for="password" class="form-label">New Password</label>
                                <input id="password" type="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <label for="password_confirmation" class="form-label">Confirm New Password</label>

                                <input id="password-confirm"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    type="password" aria-describedby="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">



                            </div>
                            <button class="btn btn-primary d-grid w-100" type="submit">Reset Password</button>
                        </form>
                    </div>
                </div>
                <!-- /Forgot Password -->
            </div>
        </div>
    </div>


    <script src="{{ asset('newdash/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('newdash/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('newdash/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('newdash/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('newdash/assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('newdash/assets/js/main.js') }}"></script>


    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>

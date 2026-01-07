@extends('dashboard.master2')
@section('admin_title', 'Admin | Change Password')
@section('content2')
    <div class="container-fluid px-3">
        <div class="card shadow-sm bg-white rounded-0">
            <div class="row">
                <div class="col-lg-3 col-6 col-md-3 col-sm-4">
                    <a href="{{ url('/admin') }}"
                        class="btn btn-primary custom-back-button d-flex align-items-center justify-content-center">
                        <i class="bx bx-home-circle me-2"></i> Dashboard
                    </a>
                </div>
                <div class="col-lg-9 col-6 col-md-9 col-sm-8">

                    <div class="d-flex align-items-center">
                        <h3 class="mt-1 d-none d-lg-block d-md-block" style="font-family: cursive;">Change Password</h3>
                        <h5 class="mt-1 d-block d-md-none d-lg-none" style="font-family: cursive;">Change Password</h5>

                    </div>


                </div>
            </div>
        </div>



        <style>
            .custom-back-button {
                font-size: 16px;
                height: 100%;
                width: 100%;
                border-radius: 0;
                text-decoration: none;
                transition: all 0.3s ease;
                font-weight: 500;
            }

            .custom-back-button:hover {
                background-color: #8c0811;
                border:0px;
            }

            .custom-back-button i {
                font-size: 18px;
            }
        </style>

        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                @include('alert')
                <div class="card shadow p-4 rounded border-0 mt-2">
                    <form action="{{ route('update.password') }}" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                        <!-- Current Password -->
                        <div class="form-group mb-3">
                            <label for="current_password" class="form-label">Current Password <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" placeholder="Enter current password" required name="current_password"
                                    id="current_password"
                                    class="form-control @error('current_password') is-invalid @enderror">
                                <span class="input-group-text toggle-password" data-target="current_password"
                                    style="cursor: pointer">
                                    <i class="bx bx-show"></i>
                                </span>
                            </div>
                            @error('current_password')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="form-group mb-3">
                            <label for="new_password" class="form-label">New Password <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" placeholder="Enter new password" required name="new_password"
                                    id="new_password" class="form-control @error('new_password') is-invalid @enderror">
                                <span class="input-group-text toggle-password" data-target="new_password"
                                    style="cursor: pointer">
                                    <i class="bx bx-show"></i>
                                </span>
                            </div>
                            @error('new_password')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Confirm New Password -->
                        <div class="form-group mb-4">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" placeholder="Confirm new password" required
                                    name="new_password_confirmation" id="new_password_confirmation"
                                    class="form-control @error('new_password_confirmation') is-invalid @enderror">
                                <span class="input-group-text toggle-password" data-target="new_password_confirmation"
                                    style="cursor: pointer">
                                    <i class="bx bx-show"></i>
                                </span>
                            </div>
                            @error('new_password_confirmation')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary py-2">
                                Update Password
                                <i class="bx bx-check-circle"></i>
                            </button>


                            <style>
                                .btn-success:hover {
                                    background-color: #8c0811;
                                    border:0px;
                                }
                            </style>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.toggle-password').forEach(function(element) {
            element.addEventListener('click', function() {
                var targetId = this.getAttribute('data-target');
                var passwordField = document.getElementById(targetId);
                var passwordFieldType = passwordField.getAttribute('type');
                if (passwordFieldType === 'password') {
                    passwordField.setAttribute('type', 'text');
                    this.innerHTML = '<i class="bx bx-hide"></i>';
                } else {
                    passwordField.setAttribute('type', 'password');
                    this.innerHTML = '<i class="bx bx-show"></i>';
                }
            });
        });
    </script>
@endsection

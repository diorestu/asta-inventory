@extends('layouts.auth')

@section('content')
<form action="{{ route('login') }}" method="POST">
    <div class="login-logo">
        <img src="{{ asset('logo-asta.png') }}" alt="img">
        <a href="/" class="login-logo logo-white">
            <img src="{{ asset('logo-asta.png') }}" alt="Img">
        </a>
    </div>
    @csrf
    <div class="card shadow">
        <div class="card-body p-5">
            <div class="login-userheading">
                <h3>Sign In</h3>
                <h4>Access the WISMA panel using your username and passcode.</h4>
            </div>

            @error('username')
                <div class="alert alert-danger rounded-pill alert-dismissible fade show">
                    {{ $message }}
                    <button type="button" class="btn-close custom-close" data-bs-dismiss="alert" aria-label="Close"><i
                            class="fas fa-xmark"></i></button>
                </div>
            @enderror

            <div class="mb-3">
                <label class="form-label">Username <span class="text-danger"> *</span></label>
                <div class="input-group">
                    <input type="text" value="{{ old('username') }}" name="username"
                        class="form-control @error('username') is-invalid @enderror border-end-0" autocomplete="false"
                        required>
                    <span class="input-group-text border-start-0">
                        <i class="ti ti-mail"></i>
                    </span>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Password <span class="text-danger">
                        *</span></label>
                <div class="pass-group">
                    <input type="password" name="password" class="pass-input form-control">
                    <span class="ti toggle-password ti-eye-off text-gray-9"></span>
                </div>
            </div>
            <div class="form-login authentication-check">
                <div class="row">
                    <div class="col-12 d-flex align-items-center justify-content-between">
                        <div class="custom-control custom-checkbox">
                            <label class="checkboxs ps-4 mb-0 pb-0 line-height-1 fs-16 text-gray-6">
                                <input type="checkbox" class="form-control">
                                <span class="checkmarks"></span>Remember me
                            </label>
                        </div>
                        {{-- <div class="text-end">
                            <a class="text-orange fs-16 fw-medium" href="forgot-password.html">Forgot
                                Password?</a>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="form-login">
                <button type="submit" class="btn btn-primary w-100">Sign In</button>
            </div>
        </div>
    </div>
</form>

@endsection
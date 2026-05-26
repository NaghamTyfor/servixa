@extends('layouts.app')

@section('styles')
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('assets/auth-custom/css/style.css') }}">
<style>
    body.auth-page {
        background-image: url('{{ asset("assets/auth-custom/images/bg.jpg") }}');
        min-height: 100vh;
    }
    .ftco-section {
        padding: 7em 0;
    }
    .img {
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
    }
    .login-wrap {
        position: relative;
    }
    .login-wrap h3 {
        font-weight: 700;
        color: #fff;
    }
    .login-wrap .form-control {
        height: 50px;
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        color: #fff;
    }
    .login-wrap .form-control:focus {
        background: rgba(255,255,255,0.2);
        border-color: #fff;
        color: #fff;
    }
    .login-wrap .form-control::placeholder {
        color: rgba(255,255,255,0.7);
    }
    .checkbox-wrap {
        color: #fff;
    }
    .field-icon {
        color: #fff;
    }
    .social a {
        color: #fff;
        text-decoration: none;
    }
    .social a:hover {
        color: #333;
    }
</style>
@endsection

@section('content')
<div class="img js-fullheight auth-page" style="background-image: url('{{ asset("assets/auth-custom/images/bg.jpg") }}');">
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">

            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0">
                        <h3 class="mb-4 text-center">Login</h3>
                        <form action="#" class="signin-form">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <input id="password-field" type="password" class="form-control" placeholder="Password" required>
                                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary submit px-3">Sign In</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="{{ asset('assets/auth-custom/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/auth-custom/js/popper.js') }}"></script>
<script src="{{ asset('assets/auth-custom/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/auth-custom/js/main.js') }}"></script>
@endsection

@section('scripts')
@endsection

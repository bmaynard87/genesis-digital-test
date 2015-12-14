@extends('layouts.auth_template')

@section('content')
        <!-- REGISTRATION FORM -->
<div class="text-center" style="padding:50px 0">
    <div class="logo">register</div>
    <!-- Main Form -->
    <div class="login-form-1">
        <form id="register-form" class="text-left" action="{{ url('auth/register') }}" method="post">
            {{ Form::hidden('_token', csrf_token()) }}
            <div class="login-form-main-message"></div>
            <div class="main-login-form">
                <div class="login-group">
                    <div class="form-group">
                        <label for="name" class="sr-only">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ Input::old('name') }}" placeholder="name">
                    </div>
                    <div class="form-group">
                        <label for="email" class="sr-only">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ Input::old('email') }}" placeholder="email">
                    </div>
                    <div class="form-group">
                        <label for="password" class="sr-only">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="password">
                    </div>
                    <div class="form-group">
                        <label for="reg_password_confirm" class="sr-only">Password Confirm</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="confirm password">
                    </div>
                </div>
                <button type="submit" class="login-button"><i class="fa fa-chevron-right"></i></button>
            </div>
            <div class="etc-login-form">
                <p>already have an account? <a href="{{ url('auth/login') }}">login here</a></p>
            </div>
            <div>
                <a class="btn btn-block btn-social btn-facebook" href="facebook">
                    <span class="fa fa-facebook"></span> Sign in with Facebook
                </a>
                <a class="btn btn-block btn-social btn-github" href="github">
                    <span class="fa fa-github"></span> Sign in with Github
                </a>
            </div>
        </form>
    </div>
    <!-- end:Main Form -->
    @include('common.errors')
</div>
@stop
@extends('layouts.auth_template')

@section('content')
    <!-- LOGIN FORM -->
    <div class="text-center" style="padding:50px 0">
        <div class="logo">login</div>
        <!-- Main Form -->
        <div class="login-form-1">
            <form id="login-form" class="text-left" action="login" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="login-form-main-message"></div>
                <div class="main-login-form">
                    <div class="login-group">
                        <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="text" class="form-control" id="lg_username" name="email" placeholder="email">
                        </div>
                        <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" class="form-control" id="lg_password" name="password" placeholder="password">
                        </div>
                    </div>
                    <button type="submit" class="login-button"><i class="fa fa-chevron-right"></i></button>
                </div>
                <div class="etc-login-form">
                    <!--<p>forgot your password? <a href="#">click here</a></p>-->
                    <p>new user? <a href="{{ url('auth/register') }}">create new account</a></p>
                    <br>
                    <div>
                        <a class="btn btn-block btn-social btn-facebook" href="facebook">
                            <span class="fa fa-facebook"></span> Sign in with Facebook
                        </a>
                        <a class="btn btn-block btn-social btn-github" href="github">
                            <span class="fa fa-github"></span> Sign in with Github
                        </a>
                    </div>
                </div>
            </form>
        </div>
        <!-- end:Main Form -->
        @include('common.errors')
    </div>
@stop
@section('page_title', 'Log In')
@section('page_class', 'admin-login teal')

@extends('admin::layouts.master')

@section('content')
<main class="section-login full-width valign-wrapper">
    <div class="container">
        <div class="row">
            <div class="col s12 m4 offset-m4">
                <div class="col s12 card white z-depth-3">
                    <img class="responsive-img center-block logo" src="{{ asset('images/logo.png') }}" alt="Logo" />
                    @include('includes.flash')
                    <form class="col s12" method="POST" action="{{ Request::url() }}" autocomplete="off">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="email" type="email" name="email" class="validate" value="{{ old('email') }}" />
                                <label for="email">Email</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="password" type="password" name="password" class="validate" />
                                <label for="password">Password</label>
                            </div>
                        </div>
                        <p>
                            <input type="checkbox" id="remember" name="remember" class="filled-in" />
                            <label for="remember">Remember Me</label>
                        </p>
                        <p class="forgot-password">
                            <i class="material-icons">lock_open</i>
                            <a href="{{ route('admin::auth.reset-password.get-email') }}">
                                Forgotten Password
                            </a>
                        </p>
                        <div class="row">
                            <div class="input-field col s12">
                                <button class="btn teal waves-effect waves-light center-block" type="submit">Log In</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

@include('admin::includes.footer')
@stop
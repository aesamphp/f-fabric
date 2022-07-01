@section('page_title', 'Forgotten your password?')
@section('page_class', 'login')

@extends('layouts.master')

@section('content')
@include('includes.mobile-nav')
@include('includes.header')

<main>
    <div class="container container-global">
        <div class="row">
            <div class="container-dotted-pattern col-xs-12 no-pad">

                <div class="row extra-margin">
                    <div class="col-xs-12 no-pad">
                        
                            <section class="col-xs-12 container-account-forms">
                                
                                @include('includes.flash')
                                
                                <div class="account-login center-block">
                                    <h2 class="account-login__hdr">Forgotten your password?</h2>
                                    <form method="POST" action="{{ route('post.reset.password') }}" class="account-login-form" autocomplete="off">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="token" value="{{ $token }}" />
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="form-group @if ($errors->has('email')) error @endif">										
                                                    <label class="account-login-form__label" for="login-email">Email Address*</label>
                                                    <input id="login-email" name="email" class="account-login-form__field field-primary" type="email" value="{{ old('email') }}" placeholder="Please enter your Email Address" />
                                                </div>
                                            </div>
                                            <div class="col-xs-12">
                                                <div class="form-group @if ($errors->has('password')) error @endif">										
                                                    <label class="account-create-form__label" for="password">Choose a Password* (at least 8 digits)</label>
                                                    <input id="password" name="password" class="account-create-form__field field-primary" type="password" placeholder="Choose a Password" />
                                                </div>
                                            </div>
                                            <div class="col-xs-12">
                                                <div class="form-group @if ($errors->has('password_confirmation')) error @endif">										
                                                    <label class="account-create-form__label" for="password_confirmation">Confirm your Password*</label>
                                                    <input id="password_confirmation" name="password_confirmation" class="account-create-form__field field-primary" type="password" placeholder="Confirm your Password" />
                                                </div>
                                            </div>
                                        </div>	
                                        <div class="account-checkbox-area--minor">
                                            <div class="row">
                                                <div class="col-sm-8 col-sm-offset-2 col-xs-12">
                                                    <button class="account-create-form__btn btn-primary" type="submit">
                                                        <span>Reset</span>
                                                    </button>
                                                </div>
                                            </div>	
                                        </div>						
                                    </form>
                                </div>
                                
                            </section>
                        
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

@include('includes.footer')
@stop
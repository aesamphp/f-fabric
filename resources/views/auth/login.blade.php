@section('page_title', 'Create Your Free Account')
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
                        <div class="col-md-5 col-xs-12 no-pad-left-md no-pad-md pull-right container-social-signup">
                            <section class="social-signup">
                                <div class="vertical-outer">
                                    <div class="vertical-inner">
                                        <h2 class="social-signup__hdr">OR</h2>
                                        <p class="social-signup__para">Sign up using your Facebook account</p>
                                        <a class="social-signup__btn btn-facebook-login" href="#">
                                            <img src="{{ asset('images/fb-sign-up.png') }}" alt="Sign up using Facebook" />
                                        </a>
                                    </div>
                                </div>
                            </section>
                        </div>	        	
                        <div class="col-md-7 col-xs-12 no-pad-right-md no-pad-md">
                            <section class="container-account-forms">
                                
                                @include('includes.flash')
                                
                                <div class="account-login">
                                    <h2 class="account-login__hdr">Already a member? Login in here</h2>
                                    <form method="POST" action="{{ Request::url() }}" class="account-login-form">
                                        {{ csrf_field() }}
                                        <div class="row">					
                                            <div class="col-xs-12 col-sm-6">
                                                <div class="form-group @if ($errors->has('email')) error @endif">										
                                                    <label class="account-login-form__label" for="login-email">Email Address*</label>
                                                    <input id="login-email" name="email" class="account-login-form__field field-primary" type="email" value="{{ old('email') }}" placeholder="Please enter your Email Address" />
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6">
                                                <div class="form-group @if ($errors->has('password')) error @endif">										
                                                    <label class="account-login-form__label" for="login-password">Password*</label>
                                                    <input id="login-password" name="password" class="account-login-form__field field-primary" type="password" placeholder="Please enter your Password" />
                                                </div>
                                            </div>							
                                        </div>	
                                        <div class="account-checkbox-area--minor">
                                            <div class="row">
                                                <div class="pull-right col-sm-5 col-xs-12">
                                                    <a class="forgot-password-link" href="{{ route('view.forgot.password') }}">Forgotten your password?</a>
                                                    <button class="account-create-form__btn btn-primary" type="submit">
                                                        <span>Log In</span>
                                                    </button>
                                                </div>
                                            </div>	
                                        </div>						
                                    </form>
                                </div>
                                
                                <div class="account-create">
                                    <h2 class="account-create__hdr">
                                        Create your free account
                                    </h2>

                                    <form method="POST" action="{{ route('post.register') }}" class="account-create-form" autocomplete="off">
                                        {{ csrf_field() }}
                                        <div class="row">					
                                            <div class="col-sm-6 col-xs-12">
                                                <div class="form-group @if ($errors->has('first_name')) error @endif">										
                                                    <label class="account-create-form__label" for="first_name">First Name*</label>
                                                    <input id="first_name" name="first_name" class="account-create-form__field field-primary" type="text" value="{{ old('first_name') }}" placeholder="Please enter your First Name" />
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-xs-12">
                                                <div class="form-group @if ($errors->has('last_name')) error @endif">										
                                                    <label class="account-create-form__label" for="last_name">Last Name*</label>
                                                    <input id="last_name" name="last_name" class="account-create-form__field field-primary" value="{{ old('last_name') }}" type="text" placeholder="Please enter your Last Name" />
                                                </div>
                                            </div>							
                                        </div>

                                        <div class="row">					
                                            <div class="col-sm-6 col-xs-12">
                                                <div class="form-group @if ($errors->has('email')) error @endif">										
                                                    <label class="account-create-form__label" for="email">Email Address*</label>
                                                    <input id="email" name="email" class="account-create-form__field field-primary" value="{{ old('email') }}" type="email" placeholder="Please enter your Email Address" />
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-xs-12">
                                                <div class="form-group @if ($errors->has('username')) error @endif">										
                                                    <label class="account-create-form__label" for="username">Username* (a-z,A-Z,0-9 and _ - . only)</label>
                                                    <input id="username" name="username" class="account-create-form__field field-primary" value="{{ old('username') }}" type="text" placeholder="Please enter your Username" />
                                                </div>
                                            </div>							
                                        </div>

                                        <div class="row">					
                                            <div class="col-sm-6 col-xs-12">
                                                <div class="form-group @if ($errors->has('password')) error @endif">										
                                                    <label class="account-create-form__label" for="password">Choose a Password* (at least 8 digits)</label>
                                                    <input id="password" name="password" class="account-create-form__field field-primary" type="password" placeholder="Choose a Password" />
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-xs-12">
                                                <div class="form-group @if ($errors->has('password_confirmation')) error @endif">										
                                                    <label class="account-create-form__label" for="password_confirmation">Confirm your Password*</label>
                                                    <input id="password_confirmation" name="password_confirmation" class="account-create-form__field field-primary" type="password" placeholder="Confirm your Password" />
                                                </div>
                                            </div>							
                                        </div>	

                                        <div class="account-checkbox-area">
                                            <div class="row">					
                                                <div class="col-sm-8 col-xs-12 no-pad-right">
                                                    <div class="account-create-form__check checkbox-container">
                                                        <input id="newsletter" type="checkbox" name="newsletter_email" value="1" checked />
                                                        <span class="checkbox-overlay"></span>
                                                        <label for="newsletter" class="checkbox-text">I wish to recieve the Fashion Formula weekly newsletter</label>
                                                    </div>
                                                    <div class="account-create-form__check checkbox-container @if ($errors->has('terms')) error @endif">
                                                        <input id="terms" type="checkbox" name="terms" value="1" />
                                                        <span class="checkbox-overlay"></span>
                                                        <label for="terms" class="checkbox-text">I confirm that I accept the <a href="{{ route('view.terms.and.conditions') }}" target="_blank">Terms of Use</a> for Fashion Formula</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 col-xs-12">
                                                    <button class="account-create-form__btn btn-primary" type="submit">
                                                        <span>Sign Up</span>
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
    </div>
</main>

@include('includes.footer')
@stop

@section('start_body')
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1693118327612452',
      cookie     : true,
      xfbml      : true,
      version    : 'v2.5'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
@stop

@section('end_body')
<script type="text/javascript">
    App.config.routes.facebookAuthURL = "{{ route('post.facebook.login') }}";
    $(function() {
        $('a.btn-facebook-login').click(function(event) {
            event.preventDefault();
            App.functions.initializeFacebook();
        });
    });
</script>
@stop
@section('page_title', 'Log In')
@section('page_class', 'admin-login teal')

@extends('admin::layouts.master')

@section('content')
<main class="section-login full-width valign-wrapper">
  <div class="container">
    <div class="row">
      <div class="col s12 m6 offset-m3">
        <div class="col s12 card white z-depth-3">
          @include('includes.flash')
          <form class="col s12" method="POST" action="{{ route('admin::auth.reset-password.store') }}" autocomplete="off">
            {{ csrf_field() }}
            <input type="hidden" name="token" value="{{ $token }}" />
            <div class="input-field col s12">
              <input id="email" type="email" name="email" class="validate" />
              <label for="email">Email</label>
            </div>
            <div class="input-field col s12">
              <input id="password" type="password" name="password" class="validate" />
              <label for="password">Password</label>
            </div>
            <div class="input-field col s12">
              <input id="password_confirmation" type="password" name="password_confirmation" class="validate" />
              <label for="password_confirmation">Confirm Password</label>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <button class="btn teal waves-effect waves-light center-block" type="submit">Request Password Reset</button>
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
@section('page_title', 'Notification Banner')
@section('page_class', 'admin-settings sticky-footer')

@extends('admin::layouts.master')

@section('content')
@include('admin::includes.header')

<main class="sticky-footer">
  <div class="container">
    <div class="row">

      @include('includes.flash')

      <div id="general" class="col s12">
        <div class="row">
           <form class="col s12" method="POST" action="{{ Request::url() }}">
            {{ csrf_field() }}
              
            @if(isset($notificationBanner))
              {{ method_field('PATCH') }}
            @endif

            <div class="input-field col s12 m6">
              <select id="banner_enable" name="enabled" class="material-select auto-select" 
                data-value="{{ !empty($notificationBanner) ? $notificationBanner->enabled : old('enabled') }}">
                <option value="" disabled>Choose your option</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
              </select>
              <label for="banner_enable">Enable Banner</label>
            </div>
            <div class="input-field col s6">
              <input id="banner_link" type="text" name="link" class="validate" 
                value="{{ !empty($notificationBanner) ? $notificationBanner->link : old('link') }}"/>
              <label for="banner_link">Banner Link</label>
            </div>
            <div class="input-field col s12">
              <input id="banner_text" type="text" name="text" class="validate" 
                value="{{ !empty($notificationBanner) ? $notificationBanner->text : old('text') }}"/>
              <label for="banner_text">Banner Content</label>
            </div>
            <div class="input-field col s12">
              <button class="btn teal waves-effect waves-light right" type="submit">Save</button>
              <a class="btn grey lighten-1 waves-effect waves-light right btn-push-left" href="{{ route('admin::view.notification.banners') }}">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>

@include('admin::includes.footer')
@stop
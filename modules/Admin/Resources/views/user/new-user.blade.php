@section('page_title', 'Add New Admin User')
@section('page_class', 'admin-catalog sticky-footer')

@extends('admin::layouts.master')

@section('content')
@include('admin::includes.header')

<main class="sticky-footer">
    <div class="container">
        <div class="row">
            
            @include('includes.flash')
            
            <form class="col s12" method="POST" action="{{ Request::url() }}" autocomplete="off">
                {{ csrf_field() }}
                <div class="row">
                    <div class="input-field col s12 m6 clearfix">
                        <input id="first_name" type="text" name="first_name" class="validate" value="{{ old('first_name') }}" />
                        <label for="first_name">First Name</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="last_name" type="text" name="last_name" class="validate" value="{{ old('last_name') }}" />
                        <label for="last_name">Last Name</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="email" type="text" name="email" class="validate" value="{{ old('email') }}" />
                        <label for="email">Email</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="username" type="text" name="username" class="validate" value="{{ old('username') }}" />
                        <label for="username">Username</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="password" type="password" name="password" class="validate" value="{{ old('password') }}" />
                        <label for="password">Password</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="password_confirmation" type="password" name="password_confirmation" class="validate" value="{{ old('password_confirmation') }}" />
                        <label for="password_confirmation">Confirm Password</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <select id="role_id" name="role_id" class="material-select auto-select" data-value="{{ old('role_id') }}">
                            <option value="" disabled>Choose your option</option>
                            {!! generateDropdownOptions($roles->toArray(), 'id', 'title') !!}
                        </select>
                        <label for="role_id">Role</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <select id="sales_email" name="sales_email" class="material-select auto-select" data-value="{{ old('sales_email') }}">
                            <option value="" disabled>Choose your option</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                        <label for="sales_email">Sales Email</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <select id="favourites_email" name="favourites_email" class="material-select auto-select" data-value="{{ old('favourites_email') }}">
                            <option value="" disabled>Choose your option</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                        <label for="favourites_email">Favourites Email</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <select id="newsletter_email" name="newsletter_email" class="material-select auto-select" data-value="{{ old('newsletter_email') }}">
                            <option value="" disabled>Choose your option</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                        <label for="newsletter_email">Newsletter Email</label>
                    </div>
                    <div class="input-field col s12">
                        <button class="btn teal waves-effect waves-light right" type="submit">Save</button>
                        <a class="btn grey lighten-1 waves-effect waves-light right btn-push-left" href="{{ route('admin::view.admins') }}">Cancel</a>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</main>

@include('admin::includes.footer')
@stop
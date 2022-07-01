@section('page_title', 'New Commission')
@section('page_class', 'admin-sales sticky-footer')

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
                    <div class="input-field col s12 m6">
                        <input id="user_friendly_id" type="text" name="user_friendly_id" class="validate" value="{{ old('user_friendly_id') }}" />
                        <label for="user_friendly_id">User Friendly ID / Email Address / Username</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="order_friendly_id" type="text" name="order_friendly_id" class="validate" value="{{ old('order_friendly_id') }}" />
                        <label for="order_friendly_id">Order Friendly ID</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="design_friendly_id" type="text" name="design_friendly_id" class="validate" value="{{ old('design_friendly_id') }}" />
                        <label for="design_friendly_id">Design Friendly ID</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <select id="type_id" name="type_id" class="material-select auto-select" data-value="{{ old('type_id') }}">
                            <option value="" disabled>Choose your option</option>
                            {!! generateDropdownOptions($typeOptions, 'id', 'title') !!}
                        </select>
                        <label for="type_id">Type</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="amount" type="text" name="amount" class="validate" value="{{ old('amount') }}" />
                        <label for="amount">Amount</label>
                    </div>
                    <div class="input-field col s12">
                        <button class="btn teal waves-effect waves-light right" type="submit">Save</button>
                        <a class="btn grey lighten-1 waves-effect waves-light right btn-push-left" href="{{ route('admin::view.commissions') }}">Cancel</a>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</main>

@include('admin::includes.footer')
@stop
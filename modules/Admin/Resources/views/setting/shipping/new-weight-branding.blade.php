@section('page_title', 'Add Shipping Weight Branding')
@section('page_class', 'admin-settings sticky-footer')

@extends('admin::layouts.master')

@section('content')
@include('admin::includes.header')

<main class="sticky-footer">
    <div class="container">
        <div class="row">

            @include('includes.flash')

            <form class="col s12" method="POST" action="{{ Request::url() }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="input-field col s12 m6">
                        <input id="title" type="text" name="title" class="validate" value="{{ old('title') }}" />
                        <label for="title">Title</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <select id="type_id" name="type_id" class="material-select auto-select" data-value="{{ old('type_id') }}">
                            <option value="" disabled>Choose your option</option>
                            {!! generateDropdownOptions($types, 'id', 'title') !!}
                        </select>
                        <label for="type_id">Type</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="max_weight" type="text" name="max_weight" class="validate" value="{{ old('max_weight') }}" />
                        <label for="max_weight">Max Weight</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="tracking_link" type="text" name="tracking_link" class="validate" value="{{ old('tracking_link') }}" />
                        <label for="tracking_link">Tracking Link</label>
                    </div>
                    <div class="input-field col s12">
                        <button class="btn teal waves-effect waves-light right" type="submit">Save</button>
                        <a class="btn grey lighten-1 waves-effect waves-light right btn-push-left" href="{{ route('admin::view.shipping.weight.brandings') }}">Cancel</a>
                    </div>
                </div>
            </form>

        </div>
    </div>
</main>

@include('admin::includes.footer')
@stop
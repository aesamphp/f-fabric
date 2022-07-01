@section('page_title', $weightBranding->title)
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
                    {{ method_field('POST') }}
                    <div class="row">

                        <div class="input-field col s12 m6">
                            <select id="package_type_id" name="package_type_id" class="material-select auto-select"
                                    data-value="{{ old('package_type_id') }}">
                                <option value="" disabled>Choose your option</option>
                                {!! generateDropdownOptions($packageTypeOptions, 'id', 'title') !!}
                            </select>
                            <label for="package_type_id">Type</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <input id="price" type="text" name="price" class="validate" value="{{ old('price') }}"/>
                            <label for="price">Price</label>
                        </div>

                        <div class="input-field col s12">
                            <button class="btn teal waves-effect waves-light right" type="submit">Save</button>
                            <a class="btn grey lighten-1 waves-effect waves-light right btn-push-left"
                               href="{{ route('admin::view.shipping.package.types') }}">Cancel</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </main>

    @include('admin::includes.footer')
@stop
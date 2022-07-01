@section('page_title', 'Add Shipping Package')
@section('page_class', 'admin-catalog sticky-footer')

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
                        <select id="package_type_id" name="package_type_id" class="material-select auto-select" data-value="{{ old('package_type_id') }}">
                            <option value="" disabled>Choose your option</option>
                            @foreach ($packageTypes as $packageType)
                            <option value="{{ $packageType->id }}">{{ $packageType->title }}</option>
                            @endforeach
                        </select>
                        <label for="package_type_id">Package Type</label>
                    </div>
                    <div class="input-field col s12">
                        <button class="btn teal waves-effect waves-light right" type="submit">Save</button>
                        <a class="btn grey lighten-1 waves-effect waves-light right btn-push-left" href="{{ route('admin::view.product', ['id' => $product->id]) }}">Cancel</a>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</main>

@include('admin::includes.footer')
@stop
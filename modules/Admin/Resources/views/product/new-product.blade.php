@section('page_title', 'Add New Product')
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
                        <select id="category_id" name="category_id" class="material-select auto-select" data-value="{{ old('category_id') }}">
                            <option value="" disabled>Choose your option</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                        <label for="category_id">Category</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="title" type="text" name="title" class="validate" value="{{ old('title') }}" />
                        <label for="title">Title</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="sku" type="text" name="sku" class="validate" value="{{ old('sku') }}" />
                        <label for="sku">SKU</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="width" type="text" name="width" class="validate" value="{{ old('width') }}" />
                        <label for="width">Width</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="width_text" type="text" name="width_text" class="validate" value="{{ old('width_text') }}" />
                        <label for="width_text">Width Text</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="height" type="text" name="height" class="validate" value="{{ old('height') }}" />
                        <label for="height">Height</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="height_text" type="text" name="height_text" class="validate" value="{{ old('height_text') }}" />
                        <label for="height_text">Height Text</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="weight" type="text" name="weight" class="validate" value="{{ old('weight') }}" />
                        <label for="weight">Weight</label>
                    </div>
                    <div class="input-field col s12">
                        <button class="btn teal waves-effect waves-light right" type="submit">Save</button>
                        <a class="btn grey lighten-1 waves-effect waves-light right btn-push-left" href="{{ route('admin::view.products') }}">Cancel</a>
                    </div>
                </div>
            </form>

        </div>
    </div>
</main>

@include('admin::includes.footer')
@stop
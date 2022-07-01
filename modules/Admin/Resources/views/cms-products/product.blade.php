@section('page_title', $product->title)
@section('page_class', 'admin-catalog sticky-footer')

@extends('admin::layouts.master')

@section('content')
@include('admin::includes.header')

<main class="sticky-footer">
    <div class="container">
        <div class="row">

            @include('includes.flash')

            <form class="col s12" method="POST" action="{{ Request::url() }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="row">
                    <div class="input-field col s12 m6">
                        <select id="category_id" name="category_id" class="material-select auto-select" data-value="{{ getFormFieldValue($product, 'category_id') }}">
                            <option value="" disabled>Choose your option</option>
                            {!! generateDropdownOptions($categories->toArray(), 'id', 'title') !!}
                        </select>
                        <label for="category_id">Category</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="title" type="text" name="title" class="validate" value="{{ getFormFieldValue($product, 'title') }}" />
                        <label for="title">Title</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea id="content" name="content" class="tinymce-editor">{!! getFormFieldValue($product, 'content') !!}</textarea>
                        <label for="content">Content</label>
                    </div>
                    @if (getFormFieldValue($product, 'image1_path'))
                    <div class="input-field col s12">
                        <img class="materialboxed" src="{{ asset(getFormFieldValue($product, 'image1_path')) }}" alt="Image 1" />
                    </div>
                    @endif
                    <div class="file-field input-field col s12">
                        <div class="btn">
                            <span>Image 1</span>
                            <input type="file" name="files[image1_path]" />
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" />
                        </div>
                    </div>
                    @if (getFormFieldValue($product, 'image2_path'))
                    <div class="input-field col s12">
                        <img class="materialboxed" src="{{ asset(getFormFieldValue($product, 'image2_path')) }}" alt="Image 2" />
                    </div>
                    @endif
                    <div class="file-field input-field col s12">
                        <div class="btn">
                            <span>Image 2</span>
                            <input type="file" name="files[image2_path]" />
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" />
                        </div>
                    </div>
                    @if (getFormFieldValue($product, 'image3_path'))
                    <div class="input-field col s12">
                        <img class="materialboxed" src="{{ asset(getFormFieldValue($product, 'image3_path')) }}" alt="Image 3" />
                    </div>
                    @endif
                    <div class="file-field input-field col s12">
                        <div class="btn">
                            <span>Image 3</span>
                            <input type="file" name="files[image3_path]" />
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" />
                        </div>
                    </div>
                    <div class="input-field col s12">
                        <button class="btn teal waves-effect waves-light right" type="submit">Save</button>
                        <a class="btn grey lighten-1 waves-effect waves-light right btn-push-left" href="{{ route('admin::view.cms.products') }}">Cancel</a>
                    </div>
                </div>
                <input type="hidden" name="image1_path" value="{{ getFormFieldValue($product, 'image1_path') }}" />
                <input type="hidden" name="image2_path" value="{{ getFormFieldValue($product, 'image2_path') }}" />
                <input type="hidden" name="image3_path" value="{{ getFormFieldValue($product, 'image3_path') }}" />
            </form>

        </div>
    </div>
</main>

@include('admin::includes.footer')
@stop
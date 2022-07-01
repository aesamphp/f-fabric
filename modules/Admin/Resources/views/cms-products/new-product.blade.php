@section('page_title', 'Add CMS Product')
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
                <div class="row">
                    <div class="input-field col s12 m6">
                        <select id="category_id" name="category_id" class="material-select">
                            <option value="" disabled>Choose your option</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}"@if ($category->id === old('category_id')) selected @endif>{{ $category->title }}</option>
                            @endforeach
                        </select>
                        <label for="category_id">Category</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="title" type="text" name="title" class="validate" value="{{ old('title') }}" />
                        <label for="title">Title</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea id="content" name="content" class="tinymce-editor">{{ old('content') }}</textarea>
                        <label for="content">Content</label>
                    </div>
                    @if (old('image1_path'))
                    <div class="input-field col s12">
                        <img class="materialboxed" src="{{ asset(old('image1_path')) }}" alt="Image 1" />
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
                    @if (old('image2_path'))
                    <div class="input-field col s12">
                        <img class="materialboxed" src="{{ asset(old('image2_path')) }}" alt="Image 2" />
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
                    @if (old('image3_path'))
                    <div class="input-field col s12">
                        <img class="materialboxed" src="{{ asset(old('image3_path')) }}" alt="Image 3" />
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
                <input type="hidden" name="image1_path" value="{{ old('image1_path') }}" />
                <input type="hidden" name="image2_path" value="{{ old('image2_path') }}" />
                <input type="hidden" name="image3_path" value="{{ old('image3_path') }}" />
            </form>

        </div>
    </div>
</main>

@include('admin::includes.footer')
@stop
@section('page_title', 'New Article')
@section('page_class', 'admin-cms sticky-footer')

@extends('admin::layouts.master')

@section('content')
@include('admin::includes.header')

<main class="sticky-footer">
    <div class="container">
        <div class="row">
            
            @include('includes.flash')
            
            <form class="col s12" method="POST" action="{{ Request::url() }}" enctype="multipart/form-data" autocomplete="off">
                {{ csrf_field() }}
                <div class="row">
                    <div class="input-field col s12 m6">
                        <input id="title" type="text" name="title" class="validate" value="{{ old('title') }}" />
                        <label for="title">Title</label>
                    </div>
                    @if (old('image_path'))
                    <div class="input-field col s12">
                        <img class="materialboxed" src="{{ asset(old('image_path')) }}" alt="Image" />
                    </div>
                    @endif
                    <div class="file-field input-field col s12">
                        <div class="btn">
                            <span>File</span>
                            <input type="file" name="file" />
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" />
                        </div>
                    </div>
                    <div class="input-field col s12">
                        <textarea id="excerpt" name="excerpt" class="materialize-textarea height-10">{{ old('excerpt') }}</textarea>
                        <label for="excerpt">Excerpt</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea id="content" name="content" class="tinymce-editor">{{ old('content') }}</textarea>
                        <label for="content">Content</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea id="tags" name="tags" class="materialize-textarea height-10">{{ old('tags') }}</textarea>
                        <label for="tags">Tags</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea id="meta_description" name="meta_description" class="materialize-textarea height-10">{{ old('meta_description') }}</textarea>
                        <label for="meta_description">Meta Description</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea id="meta_keywords" name="meta_keywords" class="materialize-textarea height-10">{{ old('meta_keywords') }}</textarea>
                        <label for="meta_keywords">Meta Keywords</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <select id="active" name="active" class="material-select auto-select" data-value="{{ old('active') }}">
                            <option value="" disabled>Choose your option</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                        <label for="active">Enabled</label>
                    </div>
                    <div class="input-field col s12">
                        <button class="btn teal waves-effect waves-light right" type="submit">Save</button>
                        <a class="btn grey lighten-1 waves-effect waves-light right btn-push-left" href="{{ route('admin::view.blog.articles') }}">Cancel</a>
                    </div>
                </div>
                <input type="hidden" name="image_path" value="{{ old('image_path') }}" />
            </form>
            
        </div>
    </div>
</main>

@include('admin::includes.footer')
@stop
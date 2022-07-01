@section('page_title', 'New Design Tip')
@section('page_class', 'admin-cms sticky-footer')

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
                    <div class="input-field col s12">
                        <textarea id="meta_description" name="meta_description" class="materialize-textarea height-10">{{ old('meta_description') }}</textarea>
                        <label for="meta_description">Meta Description</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea id="meta_keywords" name="meta_keywords" class="materialize-textarea height-10">{{ old('meta_keywords') }}</textarea>
                        <label for="meta_keywords">Meta Keywords</label>
                    </div>
                    <div class="input-field col s12">
                        <button class="btn teal waves-effect waves-light right" type="submit">Save</button>
                        <a class="btn grey lighten-1 waves-effect waves-light right btn-push-left" href="{{ route('admin::view.design.tips') }}">Cancel</a>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</main>

@include('admin::includes.footer')
@stop
@section('page_title', 'Add New Page')
@section('page_class', 'admin-cms sticky-footer')

@extends('admin::layouts.master')

@section('content')
  @include('admin::includes.header')

  <main class="sticky-footer">
    <div class="container">
      <div class="row">

        @include('includes.flash')

        <form class="col s12" method="POST" action="{{ Request::url() }}" enctype="multipart/form-data">
          {{ csrf_field() }}
          {{ method_field('POST') }}

          <div class="row">
            <div class="input-field col s12 m6">
              <input id="title" type="text" name="title" class="validate" value="{{ old('title') }}"/>
              <label for="title">Title</label>
            </div>
            <div class="input-field col s12 m6">
              <input id="url" type="text" name="url" class="validate" value="{{ old('url') }}"/>
              <label for="url">URL</label>
            </div>

            @if (old('image_path'))
              <div class="input-field col s12">
                <img class="materialboxed" src="{{ asset(old('image_path')) }}" alt="Image"/>
              </div>
            @endif
            <div class="file-field input-field col s12">
              <div class="btn">
                <span>File</span>
                <input type="file" name="file"/>
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text"/>
              </div>
            </div>

            <div data-class="restricted" class="btn btn-large">Restricted Html</div>
            <div data-class="unrestricted" class="btn btn-large">Unrestricted Html</div>

            <div class="input-field col s12 restricted content">
              <textarea class="tinymce-editor">{{ old('content') }}</textarea>
              <label for="restricted_html">Restricted HTML</label>
            </div>

            <div class="input-field col s12 unrestricted hide content">
              <textarea class="materialize-textarea height-10">{{ old('content') }}</textarea>
              <label for="unrestricted_html">Unrestricted Html</label>
            </div>

            <div class="input-field col s12">
              <textarea id="excerpt" name="excerpt"
                        class="materialize-textarea height-10">{{ old('excerpt') }}</textarea>
              <label for="excerpt">Excerpt</label>
            </div>

            <div class="input-field col s12">
              <textarea id="meta_description" name="meta_description"
                        class="materialize-textarea height-10">{{ old('meta_description') }}</textarea>
              <label for="meta_description">Meta Description</label>
            </div>
            <div class="input-field col s12">
              <textarea id="meta_keywords" name="meta_keywords"
                        class="materialize-textarea height-10">{{ old('meta_keywords') }}</textarea>
              <label for="meta_keywords">Meta Keywords</label>
            </div>
            <div class="input-field col s12 m6">
              <select id="status" name="status" class="material-select auto-select" data-value="{{ old('status') }}">
                <option value="">Choose your option</option>
                {!! generateDropdownOptions($statusTypes, 'id', 'title') !!}
              </select>
              <label for="status">Status</label>
            </div>

            <textarea id="content" name="content" class="hide">{{ old('content') }}</textarea>

            <div class="input-field col s12">
              <button class="btn teal waves-effect waves-light right" type="submit">Save</button>
              <a class="btn grey lighten-1 waves-effect waves-light right btn-push-left"
                 href="{{ route('admin::show.pages') }}">Cancel</a>
            </div>
          </div>
          <input type="hidden" name="image_path" value="{{ old('image_Path') }}"/>
        </form>

      </div>
    </div>
  </main>

  @include('admin::includes.footer')
@stop
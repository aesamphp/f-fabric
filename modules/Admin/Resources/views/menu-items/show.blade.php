@section('page_title', $menuitem->title)
@section('page_class', 'admin-catalog sticky-footer')

@extends('admin::layouts.master')

@section('content')
  @include('admin::includes.header')

  <main class="sticky-footer">
    <div class="container">
      <div class="row">

        @include('includes.flash')

        <form method="POST" action="{{ Request::url() }}" enctype="multipart/form-data">
          {{ csrf_field() }}
          {{ method_field('PATCH') }}

          <div class="row">
            <div class="input-field col s12 m6">
              <input type="text" name="sort_order" id="sort_order" class="validate"
                     value="{{ getFormFieldValue($menuitem, 'sort_order') }}">
              <label for="sort_order">Order</label>
            </div>
            <div class="input-field col s12 m6">
              <input type="text" name="title" id="title" class="validate"
                     value="{{ getFormFieldValue($menuitem, 'title') }}">
              <label for="title">Title</label>
            </div>
            <!-- INSERT ROUTES DROPDOWN -->
            <div class="input-field col s12 m6">
              <select name="route" id="route" class="material-select validate">
                @foreach($routes as $label => $value)
                  <option
                      value="{{ $value }}" {{ $value == getFormFieldValue($menuitem, 'route') ? 'selected' : null }}>{{ $label }}</option>
                @endforeach
              </select>
              <label for="route">Route</label>
            </div>
            <div class="input-field col s12 m6">
              <select name="section" id="section" class="material-select validate">
                @foreach($menusectionslist as $label => $value)
                  <option
                      value="{{ $value }}" {{ $value == getFormFieldValue($menuitem, 'menu_section_id') ? 'selected' : null }}>{{ $label }}</option>
                @endforeach
              </select>
              <label for="section">Section</label>
            </div>
            <div class="input-field col s12 m6">
              <select name="active" id="active" class="material-select validate">
                <option value="1" {{ getFormFieldValue($menuitem, 'active') == 1 ? 'selected' : null }}>Yes</option>
                <option value="0" {{ getFormFieldValue($menuitem, 'active') == 0 ? 'selected' : null }}>No</option>
              </select>
              <label for="active">Active</label>
            </div>
            <div class="input-field col s12">
              <textarea name="excerpt" id="excerpt"
                        class="materialize-textarea height-10">{{ $menuitem->excerpt }}</textarea>
              <label for="excerpt" class="active">Excerpt</label>
            </div>
            @if ($menuitem->image_path)
              <div class="input-field col s12">
                <img class="materialboxed" src="{{ asset($menuitem->image_path) }}" alt="Image"/>
              </div>
            @endif
            <div class="file-field input-field col s12">
              <div class="btn">
                <span>File</span>
                <input type="file" name="file" accept=".gif, .jpeg, .jpg, .png"/>
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text"/>
              </div>
            </div>
            <div class="input-field col s12">
              <button class="btn waves-effect waves-light right" type="submit">Save</button>
            </div>
          </div>
          <input type="hidden" name="image_path" value="{{ $menuitem->image_path }}"/>
        </form>
      </div>
    </div>
  </main>
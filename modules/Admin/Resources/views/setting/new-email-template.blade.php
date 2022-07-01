@section('page_title', 'New Email Template')
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
                        <select id="action_id" name="action_id" class="material-select">
                            <option value="" disabled>Choose your option</option>
                            @foreach ($actions as $action)
                            <option value="{{ $action->id }}"@if ($action->id === old('action_id')) selected @endif>{{ $action->title }}</option>
                            @endforeach
                        </select>
                        <label for="action_id">Action</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="title" type="text" name="title" class="validate" value="{{ old('title') }}" />
                        <label for="title">Title</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="subject" type="text" name="subject" class="validate" value="{{ old('subject') }}" />
                        <label for="subject">Subject</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea id="content" name="content" class="tinymce-editor">{{ old('content') }}</textarea>
                        <label for="content">Content</label>
                    </div>
                    <div class="input-field col s12">
                        <button class="btn teal waves-effect waves-light right" type="submit">Save</button>
                        <a class="btn grey lighten-1 waves-effect waves-light right btn-push-left" href="{{ route('admin::view.email.templates') }}">Cancel</a>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</main>

@include('admin::includes.footer')
@stop
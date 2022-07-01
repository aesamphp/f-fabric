@section('page_title', 'Add Weekly Contest')
@section('page_class', 'admin-promotions sticky-footer')

@extends('admin::layouts.master')

@section('content')
@include('admin::includes.header')

<main class="sticky-footer">
    <div class="container">
        <div class="row">

            @include('includes.flash')

            <form class="col s12" method="POST" action="{{ Request::url() }}" autocomplete="off">
                {{ csrf_field() }}
                <div class="row">
                    <div class="input-field col s12 no-padding">
                        <div class="input-field col s12 m6">
                            <input id="title" type="text" name="title" class="validate" value="{{ old('title') }}" />
                            <label for="title">Title</label>
                        </div>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="from_date" type="date" name="from_date" value="{{ old('from_date') }}" class="datepicker" placeholder="From Date" />
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="to_date" type="date" name="to_date" value="{{ old('to_date') }}" class="datepicker" placeholder="To Date" />
                    </div>
                    <div class="input-field col s12">
                        <textarea id="excerpt" name="excerpt" class="materialize-textarea height-10">{{ old('excerpt') }}</textarea>
                        <label for="excerpt">Excerpt</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea id="description" name="description" class="tinymce-editor">{{ old('description') }}</textarea>
                        <label for="description">Description</label>
                    </div>
                    <div class="input-field col s12">
                        <button class="btn teal waves-effect waves-light right" type="submit">Save</button>
                        <a class="btn grey lighten-1 waves-effect waves-light right btn-push-left" href="{{ route('admin::view.weekly.contests') }}">Cancel</a>
                    </div>
                </div>
            </form>

        </div>
    </div>
</main>

@include('admin::includes.footer')
@stop
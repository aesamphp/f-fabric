@section('page_title', $packageType->title)
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
                {{ method_field('PATCH') }}
                <div class="row">
                    <div class="input-field col s12 m6">
                        <input id="title" type="text" name="title" class="validate" value="{{ $packageType->title }}" />
                        <label for="title">Title</label>
                    </div>
                    <div class="input-field col s12">
                        <button class="btn teal waves-effect waves-light right" type="submit">Save</button>
                        <a class="btn grey lighten-1 waves-effect waves-light right btn-push-left" href="{{ route('admin::view.shipping.package.types') }}">Cancel</a>
                    </div>
                </div>
            </form>

        </div>
    </div>
</main>

@include('admin::includes.footer')
@stop
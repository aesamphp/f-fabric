@section('page_title', 'Contact Settings')
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
                    @include('admin::setting.setting-row')
                    <div class="input-field col s12">
                        <button class="btn teal waves-effect waves-light right" type="submit">Save</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</main>

@include('admin::includes.footer')
@stop
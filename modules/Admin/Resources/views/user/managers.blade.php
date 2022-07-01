@section('page_title', 'Managers')
@section('page_class', 'admin-users sticky-footer')

@extends('admin::layouts.master')

@section('content')
@include('admin::includes.header')

<main class="sticky-footer">
    <div class="container">
        <div class="row">

            @include('includes.flash')

            <form class="col s12" method="GET" action="{{ Request::url() }}">
                <div class="input-field col s12 m6 right">
                    <i class="material-icons teal-icon prefix">search</i>
                    <input id="search_keyword" type="text" name="search_keyword" class="validate" value="{{ $searchKeyword }}" />
                    <label for="search_keyword">Search</label>
                </div>
            </form>

            @if (count($users) > 0)
                <div class="clearfix"></div>
                <table class="responsive-table data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Friendly ID</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email Address</th>
                            <th>Created</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @include($ajaxViewPath)
                    </tbody>
                </table>
            @else
                <p>I don't have any records!</p>
            @endif

        </div>
    </div>
</main>

@include('admin::includes.footer')
@stop

@section('end_body')
<script type="text/javascript">App.functions.loadDataOnScroll($('table.data-table tbody'), "{{ Request::url() }}", {{ $limit }}, {{ $offset }}, {{ $count }});</script>
@stop
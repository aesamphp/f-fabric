@section('page_title', 'Design Tip Categories')
@section('page_class', 'admin-cms sticky-footer')

@extends('admin::layouts.master')

@section('content')
@include('admin::includes.header')

<main class="sticky-footer">
    <div class="container">
        <div class="row">
            
            @include('includes.flash')
            
            <div class="col s12">
                <div class="row">
                    <a class="btn teal waves-effect waves-light right" href="{{ route('admin::new.design.tip.category') }}">Add New</a>
                </div>
            </div>
            @if (count($categories) > 0)
            <table class="responsive-table data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Created</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @include('admin::design-tip.design-tip-category-row')
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
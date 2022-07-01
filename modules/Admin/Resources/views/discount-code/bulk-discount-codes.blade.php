@section('page_title', 'Bulk Discount Codes Groups')
@section('page_class', 'admin-promotions sticky-footer')

@extends('admin::layouts.master')

@section('content')
@include('admin::includes.header')

<main class="sticky-footer">
    <div class="container">
        <div class="row">

            @include('includes.flash')

            <div class="col s12">
                <div class="row">
                    <a href="{{ route('admin::view.discount.code.bulk') }}" class="btn teal waves-effect waves-light right">Generate Discount Codes</a>
                </div>
            </div>
            @if (count($discountCodeGroups) > 0)
            <table class="responsive-table data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Prefix</th>
                        <th>Use Type</th>
                        <th>Date Limit</th>
                        <th>Value</th>
                        <th>Used</th>
                        <th>Created</th>
                        <th>&nbsp</th>
                    </tr>
                </thead>
                <tbody>
                    @include('admin::discount-code.bulk-discount-code-row')
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
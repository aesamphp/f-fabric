@section('page_title', 'Commissions')
@section('page_class', 'admin-sales sticky-footer')

@extends('admin::layouts.master')

@section('content')
@include('admin::includes.header')

<main class="sticky-footer">
    <div class="container">
        <div class="row">
            
            @include('includes.flash')
            
            <div class="col s12">
                <div class="row">
                    <a class="btn teal waves-effect waves-light right" href="{{ route('admin::new.commission') }}">Add New</a>
                </div>
            </div>
            <form class="col s12" method="GET" action="{{ Request::url() }}">
                <div class="row">
                    <div class="input-field col s12 m6 left">
                        <i class="material-icons teal-icon prefix">search</i>
                        <input id="search_keyword" type="text" name="search_keyword" class="validate" value="{{ $searchKeyword }}" />
                        <label for="search_keyword">Search</label>
                    </div>
                </div>
                <div class="input-field col s12">
                    <button class="btn teal waves-effect waves-light right" type="submit">Search</button>
                </div>
            </form>
            
            @if (count($commissions) > 0)
            <form class="col s12" method="POST" action="{{ route('admin::download.commissions') }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="input-field col s12 m6">
                        <input id="from_date" type="date" name="from_date" value="{{ old('from_date') }}" class="datepicker" placeholder="From Date" />
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="to_date" type="date" name="to_date" value="{{ old('to_date') }}" class="datepicker" placeholder="To Date" />
                    </div>
                    <div class="input-field col s12">
                        <button class="btn teal waves-effect waves-light right" type="submit">Download</button>
                    </div>
                </div>
            </form>
            <form class="col s12" method="POST" action="{{ route('admin::update.commissions.status') }}">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="row">
                    <div class="input-field col s12 m6 right">
                        <select id="status" name="status" class="material-select" onchange="this.form.submit();">
                            <option value="">Please Select</option>
                            <option value="paid">Paid</option>
                        </select>
                        <label for="status">Bulk Action</label>
                    </div>
                </div>
                <table class="responsive-table data-table">
                    <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>ID</th>
                            <th>Designer ID</th>
                            <th>Designer Name</th>
                            <th>Order ID</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @include('admin::sale.commission-row')
                    </tbody>
                </table>
            </form>
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
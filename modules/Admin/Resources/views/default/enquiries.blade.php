@section('page_title', 'Enquiries')
@section('page_class', 'admin-enquiries sticky-footer')

@extends('admin::layouts.master')

@section('content')
@include('admin::includes.header')

<main class="sticky-footer">
    <div class="container">
        <div class="row">
            
            @include('includes.flash')
            
            @if (count($enquiries) > 0)
            <form class="col s12" method="GET" action="{{ Request::url() }}">
                <div class="row">
                    <div class="input-field col s12 m6">
                        <input id="from_date" type="date" name="from_date" value="{{ $fromDate }}" class="datepicker" placeholder="From Date" />
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="to_date" type="date" name="to_date" value="{{ $toDate }}" class="datepicker" placeholder="To Date" />
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m6 left">
                        <i class="material-icons teal-icon prefix">search</i>
                        <input id="search_keyword" type="text" name="search_keyword" class="validate" value="{{ $searchKeyword }}" />
                        <label for="search_keyword">Search</label>
                    </div>
                    <div class="input-field col s12 m6 right">
                        <select id="sort_by" name="sort_by" class="material-select auto-select" data-value="{{ $sort_by }}">
                            <option value="new">New</option>
                            <option value="name">Name</option>
                        </select>
                        <label for="sort_by">Sort By</label>
                    </div>
                </div>
                <div class="input-field col s12">
                    <button class="btn teal waves-effect waves-light right" type="submit">Search</button>
                </div>
            </form>
            <table class="responsive-table data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email Address</th>
                        <th>Phone #</th>
                        <th>Subject</th>
                        <th>Created</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @include('admin::default.enquiry-row')
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
<script type="text/javascript">
    $(function() {
        $('select#sort_by').change(function() {
            var $this = $(this),
                $form = $this.parents('form');
            $form.submit();
        });
    });
    App.functions.loadDataOnScroll($('table.data-table tbody'), "{{ Request::url() }}", {{ $limit }}, {{ $offset }}, {{ $count }});
</script>
@stop

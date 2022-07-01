@section('page_title', 'Designs')
@section('page_class', 'admin-catalog sticky-footer')

@extends('admin::layouts.master')

@section('content')
@include('admin::includes.header')

<main class="sticky-footer">
    <div class="container">
        <div class="row">
            
            @include('includes.flash')
            
            <form class="col s12" method="POST" action="{{ route('admin::download.designs') }}">
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
            <form class="col s12" method="GET" action="{{ Request::url() }}">
                <div class="input-field col s12 m6 right">
                    <i class="material-icons teal-icon prefix">search</i>
                    <input id="search_keyword" type="text" name="search_keyword" class="validate" value="{{ $searchKeyword }}" />
                    <label for="search_keyword">Search</label>
                </div>
            </form>
            
            @if (count($designs) > 0)
            <div class="clearfix"></div>
            <table class="responsive-table data-table">
                <colgroup>
                    <col />
                    <col />
                    <col />
                    <col />
                    <col />
                    <col />
                    <col />
                    <col width="145" />
                </colgroup>
                <thead>
                    <tr>
                        <th>ID</th>
                        <td>Image</td>
                        <th>Title</th>
                        <th>Designer</th>
                        <th>Status</th>
                        <th>Sell</th>
                        <th>Created</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @include('admin::design.design-row')
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
        App.functions.loadDataOnScroll($('table.data-table tbody'), "{{ Request::url() }}", {{ $limit }}, {{ $offset }}, {{ $count }});
        $(document).on('submit', '.activate-form', function(event) {
            event.preventDefault();
            var $form = $(this),
                $btn = $form.find('button');
            $btn.prop('disabled', true);
            $.post($form.attr('action'), $form.serializeArray(), function(response) {
                $form.remove();
                alert(response);
            }).fail(function(error) {
                $btn.prop('disabled', false);
                console.log(error);
                alert('Error activating design. Please try again.');
            });
        });
    });
</script>
@stop
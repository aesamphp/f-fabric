\@section('page_title', 'Menus')
@section('page_class', 'admin-cms sticky-footer')

@extends('admin::layouts.master')

@section('content')
  @include('admin::includes.header')

  <main class="sticky-footer">
    <div class="container">
      <div class="row">

        @if (count($menus) > 0)
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
            @include('admin::menu.menu-row')
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
  <script
      type="text/javascript">App.functions.loadDataOnScroll($('table.data-table tbody'), "{{ Request::url() }}", {{ $limit }}, {{ $offset }}, {{ $count }});</script>
@stop
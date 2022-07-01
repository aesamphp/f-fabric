@section('page_title', 'Material Categories')
@section('page_class', 'admin-catalog sticky-footer')

@extends('admin::layouts.master')

@section('content')
    @include('admin::includes.header')

    <main class="sticky-footer">
        <div class="container">
            <div class="row">

                @include('includes.flash')

                <div class="col s12">
                    <div class="row">
                        <a class="btn teal waves-effect waves-light right"
                           href="{{ route('admin::add.material-category') }}">Add New</a>
                    </div>
                </div>

                <p class="well">
                    To sort the material categories, click and drag the row to the desired order that will be displayed on the frontend. The first in the table below will be the first in the dropdown on the frontend etc.
                </p>

                @if (count($materialCategories) > 0)
                    <table class="responsive-table data-table sort-table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @include('admin::material-category.row')
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
        $(".sort-table").tableDnD();

        $('body').find('.sort').mouseup(function () {
            $('body').find('.sort').each(function (key, value) {
                $.get(
                    $(this).data('action'),
                    {sort: key + 1},
                    function (response) {
                        $('body').find('.alert').remove();

                        if (response.success) {
                            $('.alert-container').append('<div class="alert alert-success">' + response.message + '</div>');
                            return false;
                        }

                        $('.alert-container').append('<div class="alert alert-danger">' + response.message + '</div>');
                        return false;
                    }
                );
            });
        });
    </script>
@stop
@section('page_title', $materialCategory->title)
@section('page_class', 'admin-catalog sticky-footer')

@extends('admin::layouts.master')

@section('content')
    @include('admin::includes.header')

    <main class="sticky-footer">
        <div class="container">
            <div class="row top-row">

                @include('includes.flash')
                <div class="col s12">
                    <div class="row">
                        <a class="btn delete-btn waves-effect waves-light right"
                           href="{{ route('admin::delete.material-category', ['id' => $materialCategory->id]) }}">Delete</a>
                    </div>
                </div>

                <form class="col s12" method="POST" action="{{ Request::url() }}">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <input id="title" type="text" name="title" class="validate" value="{{ $materialCategory->title }}"/>
                            <label for="title">Title</label>
                        </div>
                    </div>

                    @if ($materialCategory->materials)
                        <p>
                            These are the materials assigned to this material category. If you want to delete this material category there can't be any material categories assigned to it. <br /><br />
                            <strong>If a material has no material category it will not be displayed on design creation material dropdown.</strong>
                        </p>

                        <table class="responsive-table data-table">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($materialCategory->materials as $material)
                                    <tr>
                                        <td>{{ $material->title }}</td>
                                        <td>
                                            <div class="btn-delete" type="submit" title="Delete" data-action="{{ route('admin::delete.material-category.material', ['id' => $materialCategory->id, 'material_id' => $material->id]) }}">
                                                <i class="material-icons teal-icon">delete</i>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    <div class="row">
                        <div class="input-field col s12">
                            <button class="btn teal waves-effect waves-light right" type="submit">Save</button>
                            <a class="btn grey lighten-1 waves-effect waves-light right btn-push-left" href="{{ route('admin::view.material-categories') }}">Cancel</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </main>

    @include('admin::includes.footer')
@stop

@section('end_body')
    <script type="text/javascript">

        $('.material-icons').click(function () {
            var $this = $(this)
            var action = $(this).closest('.btn-delete').data('action');

            $.get(action, function (response) {

                if (response.success == true) {
                    $('.top-row').prepend('<div class="alert alert-success">' + response.message + '</div>');
                    $this.closest('tr').remove();

                    return false;
                }

                $('.top-row').prepend('<div class="alert alert-danger">' + response.message + '</div>');
            });
        });

    </script>
@stop

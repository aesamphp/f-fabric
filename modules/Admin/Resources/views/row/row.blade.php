@section('page_title', 'Edit Row')
@section('page_class', 'admin-cms sticky-footer')

@extends('admin::layouts.master')

@section('content')
    @include('admin::includes.header')

    <main class="sticky-footer">
        <div class="container">
            <div class="row">

                @include('includes.flash')

                <form class="col s12" method="GET" id="form" action="{{ route('admin::update.row', ['id' => $row->id]) }}"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('GET') }}
                    <input type="hidden" name="row_id" value="{{ $row->id }}"/>
                    <div class="row">

                        <div class="input-field col s12 m6">
                            <input id="title" type="text" name="title" class="validate" value="{{ $row->title }}"/>
                            <label for="title">Title</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <select id="status" name="status" class="material-select auto-select"
                                    data-value="{{ $row->status }}">
                                <option value="">Choose your option</option>
                                {!! generateDropdownOptions($statusTypes, 'id', 'title') !!}
                            </select>
                            <label for="status">Status</label>
                        </div>

                        <div class="input-field col s12 m6 type">
                            <select id="type" name="type" class="material-select auto-select"
                                    data-value="{{ $row->type }}">
                                <option value="">Choose your option</option>
                                {!! generateDropdownOptions($rowTypes, 'id', 'title') !!}
                            </select>
                            <label for="type">Type</label>
                        </div>

                        <div class="data-types">

                            <div class="input-field col s12 m6 default row-data @if(!($row->type == App\Models\Row::ROW_TYPE_DEFAULT)) hide @endif">
                                <select id="default" name="default" class="material-select auto-select"
                                        data-value="{{ $row->data }}">
                                    <option value="">Choose your option</option>
                                    {!! generateDropdownOptions($defaultRowOptions, 'id', 'title') !!}
                                </select>
                                <label for="default">Default Row Type</label>
                            </div>

                            <div class="input-field col s12 m6 label row-data @if(!($row->type == App\Models\Row::ROW_TYPE_LABEL)) hide @endif">
                                <select id="label" name="label" class="material-select auto-select"
                                        data-value="{{ $row->data }}">
                                    <option value="">Choose your option</option>
                                    @foreach($labels as $label)
                                        <option value="{{ $label->id }}">{{ $label->title }}</option>
                                    @endforeach
                                </select>
                                <label for="label">Label</label>
                            </div>

                            <div class="col-md-6 col-xs-12 user row-data @if(!($row->type == App\Models\Row::ROW_TYPE_DESIGNER)) hide @endif">
                                <form method="GET" class="header-rightside__search input-grouped">
                                    <input class="user-search" type="search" name="user_keyword" data-action="{{ route('admin::search.user') }}"
                                           value="{{ old('user_keyword') }}" maxlength="25"
                                           placeholder="Search for a designer by their first or last name"/>
                                    <button class="btn teal waves-effect waves-light right">Search</button>
                                </form>
                            </div>

                            <div class="user-container @if(!($row->type == App\Models\Row::ROW_TYPE_DESIGNER)) hide @endif">
                                @include('admin::row.user-searched-result', ['user' => $row->studio()])
                            </div>

                            <div class="col-md-6 col-xs-12 design row-data @if(!($row->type == App\Models\Row::ROW_TYPE_DESIGN)) hide @endif">
                                <form method="GET" class="header-rightside__search input-grouped">
                                    <input class="design-search" type="search" name="design_keyword" data-action="{{ route('admin::search.design') }}"
                                           value="{{ old('design_keyword') }}" maxlength="25"
                                           placeholder="Search for a design by name"/>
                                    <button class="btn teal waves-effect waves-light right">Search</button>
                                </form>
                            </div>

                            <div class="selected-design-container"></div>

                            <div class="design-container @if(!($row->type == App\Models\Row::ROW_TYPE_DESIGN)) hide @endif">
                                @include('admin::row.design-searched-result', ['designs' => $row->designs])
                            </div>

                        </div>

                        <input type="hidden" id="data" name="data" value="{{ $row->data }}"/>
                        <input type="hidden" id="design-data" name="design-data"
                               value="@foreach($row->designs as $design) {{ $design->id }} @endforeach"/>

                        <div class="input-field col s12">
                            <button class="btn teal waves-effect waves-light right" type="submit">Save</button>
                            <a class="btn grey lighten-1 waves-effect waves-light right btn-push-left"
                               href="{{ route('admin::view.row') }}">Cancel</a>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </main>

    @include('admin::includes.footer')
@stop

@section('end_body')
    <script type="text/javascript" src="{{ asset('js/row.js') }}"></script>
@stop
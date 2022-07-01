@section('page_title', 'Add Row')
@section('page_class', 'admin-cms sticky-footer')

@extends('admin::layouts.master')

@section('content')
    @include('admin::includes.header')

    <main class="sticky-footer">
        <div class="container">
            <div class="row">

                @include('includes.flash')

                <form class="col s12" method="GET" id="form" action="{{ route('admin::store.new.row') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('GET') }}
                    <input type="hidden" name="row_id" value="{{ old('id') }}"/>
                    <div class="row">

                        <div class="input-field col s12 m6">
                            <input id="title" type="text" name="title" class="validate" value="{{ old('title') }}"/>
                            <label for="title">Title</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <select id="status" name="status" class="material-select auto-select" data-value="{{ old('status') }}">
                                <option value="">Choose your option</option>
                                {!! generateDropdownOptions($statusTypes, 'id', 'title') !!}
                            </select>
                            <label for="status">Status</label>
                        </div>

                        <div class="input-field col s12 m6 type">
                            <select id="type" name="type" class="material-select auto-select" data-value="{{ old('type') }}">
                                <option value="">Choose your option</option>
                                {!! generateDropdownOptions($rowTypes, 'id', 'title') !!}
                            </select>
                            <label for="type">Type</label>
                        </div>

                        <div class="data-types">
                            <div class="input-field col s12 m6 hide default row-data">
                                <select id="default" name="default" class="material-select auto-select" data-value="{{ old('data') }}">
                                    <option value="">Choose your option</option>
                                    {!! generateDropdownOptions($defaultRowOptions, 'id', 'title') !!}
                                </select>
                                <label for="default">Default Row Type</label>
                            </div>

                            <div class="input-field col s12 m6 hide label row-data">
                                <select id="label" name="label" class="material-select auto-select" data-value="{{ old('data') }}">
                                    <option value="">Choose your option</option>
                                    @foreach($labels as $label)
                                        <option value="{{ $label->id }}">{{ $label->title }}</option>
                                    @endforeach
                                </select>
                                <label for="label">Label</label>
                            </div>

                            <div class="col-md-6 col-xs-12 user hide row-data">
                                <form method="GET" class="header-rightside__search input-grouped">
                                    <input class="user-search" type="search" name="user_keyword" value="{{ old('user_keyword') }}"
                                           data-action="{{ route('admin::search.user') }}"
                                           maxlength="25" placeholder="Search for a designer by their first or last name" />
                                    <button class="btn teal waves-effect waves-light right">Search</button>
                                </form>
                            </div>

                            <div class="user-container"></div>


                            <div class="col-md-6 col-xs-12 design hide row-data">
                                <form method="GET" class="header-rightside__search input-grouped">
                                    <input class="design-search" type="search" name="design_keyword" value="{{ old('design_keyword') }}"
                                           data-action="{{ route('admin::search.design') }}"
                                           maxlength="25" placeholder="Search for a design by name" />
                                    <button class="btn teal waves-effect waves-light right">Search</button>
                                </form>
                            </div>

                            <div class="selected-design-container"></div>
                            <div class="design-container"></div>

                        </div>

                        <input type="hidden" id="data" name="data" />
                        <input type="hidden" id="design-data" name="design-data" />

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
@section('page_title', $material->title)
@section('page_class', 'admin-catalog sticky-footer')

@extends('admin::layouts.master')

@section('content')
@include('admin::includes.header')

<main class="sticky-footer">
    <div class="container">
        <div class="row">

            @include('includes.flash')

            <form class="col s12" method="POST" action="{{ Request::url() }}">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="row">
                    <div class="input-field col s12 m6">
                        <select id="material_category_id" name="material_category_id" class="material-select">
                            <option value="" disabled>Choose your option</option>
                            @foreach ($materialCategories as $materialCategory)
                                <option value="{{ $materialCategory->id }}" @if ($materialCategory->id === $material->material_category_id) selected @endif>{{ $materialCategory->title }}</option>
                            @endforeach
                        </select>
                        <label for="group_id">Category</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <select id="group_id" name="group_id" class="material-select">
                            <option value="" disabled>Choose your option</option>
                            @foreach ($groups as $group)
                                <option value="{{ $group->id }}"@if ($group->id === $material->group_id) selected @endif>{{ $group->title }}</option>
                            @endforeach
                        </select>
                        <label for="group_id">Group</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="code" type="text" name="code" class="validate" value="{{ $material->code }}" />
                        <label for="code">Code</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="title" type="text" name="title" class="validate" value="{{ $material->title }}" />
                        <label for="title">Title</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea id="composition" name="composition" class="materialize-textarea height-10">{{ $material->composition }}</textarea>
                        <label for="composition">Composition</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="gsm" type="text" name="gsm" class="validate" value="{{ $material->gsm }}" />
                        <label for="gsm">GSM</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="max_width" type="text" name="max_width" class="validate" value="{{ $material->max_width }}" />
                        <label for="max_width">Max Width</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea id="description" name="description" class="materialize-textarea height-10">{{ $material->description }}</textarea>
                        <label for="description">Description</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="machine_name" type="text" name="machine_name" class="validate" value="{{ $material->machine_name }}" />
                        <label for="machine_name">Machine Name</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="profile" type="text" name="profile" class="validate" value="{{ $material->profile }}" />
                        <label for="profile">Profile</label>
                    </div>
                    <div class="input-field col s12">
                        <button class="btn teal waves-effect waves-light right" type="submit">Save</button>
                        <a class="btn grey lighten-1 waves-effect waves-light right btn-push-left" href="{{ route('admin::view.materials') }}">Cancel</a>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</main>

@include('admin::includes.footer')
@stop
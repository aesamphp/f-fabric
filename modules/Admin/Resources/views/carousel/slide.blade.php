@section('page_title', 'Edit Slide')
@section('page_class', 'admin-cms sticky-footer')

@extends('admin::layouts.master')

@section('content')
@include('admin::includes.header')

<main class="sticky-footer">
    <div class="container">
        <div class="row">

            @include('includes.flash')

            <form class="col s12" method="POST" action="{{ Request::url() }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <input type="hidden" name="carousel_id" value="{{ $carousel->id }}" />
                <div class="row">
                    @if ($slide->image_path)
                    <div class="input-field col s12">
                        <img class="materialboxed" src="{{ asset($slide->image_path) }}" alt="Image" />
                    </div>
                    @endif
                    <div class="file-field input-field col s12">
                        <div class="btn">
                            <span>File</span>
                            <input type="file" name="file" />
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" />
                        </div>
                    </div>

                    <div class="input-field col s12">
                        <textarea id="content_1" name="content" class="materialize-textarea height-10">{{ $slide->content }}</textarea>
                        <label for="content">Content</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <select id="cta_type" name="cta_type" class="material-select auto-select" data-value="{{ $slide->cta_type }}">
                            <option value="">Choose your option</option>
                            {!! generateDropdownOptions($ctaTypes, 'id', 'title') !!}
                        </select>
                        <label for="cta_type">CTA Type</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="cta_title" type="text" name="cta_title" class="validate" value="{{ $slide->cta_title }}" />
                        <label for="cta_title">CTA Title</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="cta_href" type="text" name="cta_href" class="validate" value="{{ $slide->cta_href }}" />
                        <label for="cta_href">CTA Link</label>
                    </div>
                        <div class="input-field col s12 m6">
                            <input id="sort" type="text" name="sort" class="validate" value="{{ $slide->sort }}" />
                            <label for="sort">Sort</label>
                        </div>
                    <div class="input-field col s12">
                        <button class="btn teal waves-effect waves-light right" type="submit">Save</button>
                        <a class="btn grey lighten-1 waves-effect waves-light right btn-push-left" href="{{ route('admin::view.carousel', ['id' => $carousel->id]) }}">Cancel</a>
                    </div>
                </div>
                <input type="hidden" name="image_path" value="{{ $slide->image_path }}" />
            </form>

        </div>
    </div>
</main>

@include('admin::includes.footer')
@stop
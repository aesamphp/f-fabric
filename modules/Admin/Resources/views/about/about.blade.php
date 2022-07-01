@section('page_title', 'Edit About Us page')
@section('page_class', 'admin-cms sticky-footer')

@extends('admin::layouts.master')

@section('content')
@include('admin::includes.header')

<main class="sticky-footer">
    <div class="container">
        <div class="row">

            @include('includes.flash')

            <form class="col s12 about" method="POST" action="{{ Request::url() }}">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="row">

                    <h5>Header</h5>

                    <div class="input-field col s12">
                        <input id="title" type="text" name="header_title" class="validate" value="{{ $aboutUs->header_title }}"/>
                        <label for="header_title">Title</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="title" type="text" name="header_content" class="validate" value="{{ $aboutUs->header_content }}"/>
                        <label for="header_content">Content</label>
                    </div>

                    <div class="input-field col s12">
                        <h6>Current Image</h6>
                        <img class="image" src="{{ asset($aboutUs->header_image) }}">
                    </div>

                    <div class="file-field input-field col s12">
                        <div class="btn">
                            <span>Image</span>
                            <input type="file" name="header_image_tmp" />
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" />
                        </div>
                    </div>

                    <h5>Section 1</h5>

                    <div class="input-field col s12">
                        <input id="title" type="text" name="section_1_title" class="validate" value="{{ $aboutUs->section_1_title }}"/>
                        <label for="section_1_title">Title</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea id="section_1_content_tmp" name="section_1_content_tmp" class="tinymce-editor">{{ $aboutUs->section_1_content }}</textarea>
                        <label for="section_1_content_tmp">Content</label>
                    </div>

                    <h5>Section 2</h5>

                    <div class="input-field col s12">
                        <input id="title" type="text" name="section_2_title" class="validate" value="{{ $aboutUs->section_2_title }}"/>
                        <label for="section_2_title">Title</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea id="section_2_content_tmp" name="section_2_content_tmp" class="tinymce-editor">{{ $aboutUs->section_2_content }}</textarea>
                        <label for="section_2_content_tmp">Content</label>
                    </div>
                    <div class="input-field col s12">
                        <h6>Current Image</h6>
                        <img class="image" src="{{ asset($aboutUs->section_2_image) }}">
                    </div>
                    <div class="file-field input-field col s12">
                        <div class="btn">
                            <span>Image</span>
                            <input type="file" name="section_2_image_tmp" />
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" />
                        </div>
                    </div>
                    <div class="col s12 checkbox" id="btn-fields-s2">
                        <input type="checkbox" id="section_2_button_display" name="section_2_button_display" class="filled-in" value="0" />
                        <label for="section_2_button_display">Display button</label>
                    </div>
                    <div class="btn-fields-s2 hide">
                        <div class="input-field col s12">
                            <input id="title" type="text" name="section_2_button_title" class="validate" value="{{ $aboutUs->section_2_button_title}}"/>
                            <label for="section_2_button_title">Button Text</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="title" type="text" name="section_2_button_url" class="validate" value="{{ $aboutUs->section_2_button_url }}"/>
                            <label for="section_2_button_url">Button URL</label>
                        </div>
                    </div>

                    <h5>Section 3</h5>

                    <div class="input-field col s12">
                        <input id="title" type="text" name="section_3_title" class="validate" value="{{ $aboutUs->section_3_title }}"/>
                        <label for="section_3_title">Title</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea id="section_3_content_tmp" name="section_3_content_tmp" class="tinymce-editor">{{ $aboutUs->section_3_content }}</textarea>
                        <label for="section_3_content_tmp">Content</label>
                    </div>
                    <div class="file-field input-field col s12">
                        <div class="btn">
                            <span>Image</span>
                            <input type="file" name="section_3_image_tmp" />
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" />
                        </div>
                    </div>
                    <div class="col s12 checkbox" id="btn-fields-s3">
                        <input type="checkbox" id="section_3_button_display" name="section_3_button_display" class="filled-in" />
                        <label for="section_3_button_display">Display button</label>
                    </div>
                    <div class="input-field col s12">
                        <h6>Current Image</h6>
                        <img class="image" src="{{ asset($aboutUs->section_3_image) }}">
                    </div>
                    <div class="btn-fields-s3 hide">
                        <div class="input-field col s12">
                            <input id="title" type="text" name="section_3_button_title" class="validate" value="{{ $aboutUs->section_3_button_title }}"/>
                            <label for="section_3_button_title">Button Text</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="title" type="text" name="section_3_button_url" class="validate" value="{{ $aboutUs->section_3_button_url }}"/>
                            <label for="section_3_button_url">Button URL</label>
                        </div>
                    </div>

                    <h5>Section 4</h5>
                    <div class="input-field col s12">
                        <input id="title" type="text" name="section_4_title" class="validate" value="{{ $aboutUs->section_4_title }}"/>
                        <label for="section_4_title">Title</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="title" type="text" name="section_4_video" class="validate" value="{{ $aboutUs->section_4_video }}"/>
                        <label for="section_4_video">Video URL</label>
                    </div>
                </div>

                <div class="input-field col s12">
                    <button class="btn teal waves-effect waves-light right" type="submit">Save</button>
                    <a class="btn grey lighten-1 waves-effect waves-light right btn-push-left" href="{{ route('admin::view.blog.articles') }}">Cancel</a>
                </div>
                <input type="hidden" name="image_path" value="{{ old('image_path') }}" />

                <input type="hidden" name="section_1_content" id="section_1_content">
                <input type="hidden" name="section_2_content" id="section_2_content">
                <input type="hidden" name="section_3_content" id="section_3_content">
            </form>

        </div>
    </div>
</main>

@include('admin::includes.footer')
@stop

@section('end_body')
    <script type="text/javascript">
        $('form').on('submit', function () {
            $.each(['section_1_content', 'section_2_content', 'section_3_content'], function (key, value) {
                $('#' + value).val($("#" + value + "_tmp_ifr").contents().find("#tinymce p").html());
            });
        });

        $('.checkbox').change(function () {
            $(this).find('input').prop('checked');
            $(this).find('label').addClass('active');
            $('.'+$(this).attr('id')).toggleClass('hide');
            return false;
        });
    </script>
@stop


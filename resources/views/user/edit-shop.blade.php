@extends('layouts.master')

@section('page_title', 'Update Shop')
@section('page_class', 'page-update-shop')
@section('content')

@include('includes.mobile-nav')
@include('includes.header')

<main>

    <div class="container container-global">
        <div class="row">

            <div class="col-xs-12 container-dotted-pattern no-pad">
                <section class="update-options clearfix">
                    @include('includes.flash')
                    <h1 class="update-options__hdr hdr-section">Update your shop details</h1>
                    <form method="POST" action="{{ Request::url() }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="col-sm-12 col-md-7">
                            <div class="update-options-main">
                                <div class="row">
                                    <div class="col-sm-5 col-xs-12 boot-style-right">
                                        <div class="update-options-form form-group">
                                            <label class="update-options-form__label" for="first_name">First Name*</label>
                                            <input class="update-options-form__field field-secondary" id="first_name" type="text" name="first_name" value="{{ getFormFieldValue($shop, 'first_name') }}" placeholder="Please enter your First Name" />
                                        </div>
                                        <div class="update-options-form form-group">
                                            <label class="update-options-form__label" for="last_name">Last Name*</label>
                                            <input class="update-options-form__field field-secondary" id="last_name" type="text" name="last_name" value="{{ getFormFieldValue($shop, 'last_name') }}" placeholder="Please enter your Last Name" />
                                        </div>
                                        <div class="update-options-form form-group">
                                            <label class="update-options-form__label" for="city">City</label>
                                            <input class="update-options-form__field field-secondary" id="city" type="text" name="city" value="{{ getFormFieldValue($shop, 'city') }}" placeholder="Please enter your City" />
                                        </div>
                                        <div class="update-options-form form-group">
                                            <label class="update-options-form__label" for="postcode">Zip/Postal Code</label>
                                            <input class="update-options-form__field field-secondary" id="postcode" type="text" name="postcode" value="{{ getFormFieldValue($shop, 'postcode') }}" placeholder="Please enter your Post/Zip Code" />
                                        </div>
                                        <div class="update-options-form form-group">
                                            <label class="update-options-form__label" for="country">Country</label>
                                            <select id="country" name="country" class="auto-select" data-value="{{ getFormFieldValue($shop, 'country') }}">
                                                <option value="">Please Select</option>
                                                {!! generateDropdownFromArray($countries) !!}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-7 col-xs-12 boot-style-left">
                                        <div class="update-options-form form-group">
                                            <label class="update-options-form__label" for="about_me">About me</label>
                                            <textarea rows="13" class="update-options-form__field update-options-form__field--textarea field-secondary" id="about_me" name="about_me">{{ getFormFieldValue($shop, 'about_me') }}</textarea>
                                        </div>
                                        <div class="update-options-form form-group">
                                            <label class="update-options-form__label">Optional Links</label>
                                        </div>
                                        <div class="update-options-form update-options-form--http form-group clearfix">
                                            <span class="http">My Store - http://</span>
                                            <input class="update-options-form__field field-secondary" type="text" name="store_link" value="{{ getFormFieldValue($shop, 'store_link') }}" placeholder="http:// Please enter URL here" />
                                        </div>
                                        <div class="update-options-form update-options-form--http form-group clearfix">
                                            <span class="http">My Blog - http://</span>
                                            <input class="update-options-form__field field-secondary" type="text" name="blog_link" value="{{ getFormFieldValue($shop, 'blog_link') }}" placeholder="http:// Please enter URL here" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-5">
                            <div class="update-options-side clearfix">
                                <div class="upload-area">
                                    <h3 class="upload-area__hdr hdr-section">Shop Image</h3>
                                    @if ($shop->image_path)
                                        <div class="upload-area-img upload-area-img--added-image" style="background-image:url('{{ asset($shop->image_path) }}');"></div>
                                    @else
                                        <div class="upload-area-img"></div>
                                    @endif
                                    <div class="upload-area-textarea">
                                        <div class="upload minor">
                                            <input id="file-input" class="upload__btn" type="file" name="image_file" />
                                            <div class="upload__overlay btn-tertiary--gray"><span>Choose File</span></div>
                                        </div>
                                        <p class="upload-area-textarea__para">Shop image dimensions (150px X 150px)<br />(File must be less than 1 MB)</p>
                                    </div>
                                    @if ($shop->image_path)
                                        <div class="upload minor remove-img">
                                            <a href="#" class="js-popup-btn" data-id="remove-shop-image">
                                                <div class="upload__overlay btn-tertiary--gray">
                                                    <span>Remove Shop Image</span>
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                    <h3 class="upload-area__hdr upload-area__hdr--banner hdr-section">Shop Header</h3>
                                        @if ($shop->header_image_path)
                                            <div class="upload-area-bannerimage active-thumb" style="background-image:url('{{ asset($shop->header_image_path) }}');"></div>
                                        @else
                                            <div class="upload-area-bannerimage"></div>
                                        @endif
                                    <div class="upload-area-bannertext clearfix">
                                        <p class="upload-area-bannertext__para">Header image dimensions (1170px X 140px)<br />(File must be less than 1 MB)</p>
                                        <div class="upload minor">
                                            <input id="file-input" class="upload__btn" type="file" name="header_image_file" />
                                            <div class="upload__overlay btn-tertiary--gray"><span>Choose File</span></div>
                                        </div>
                                    </div>
                                    @if ($shop->header_image_path)
                                        <div class="upload minor remove-header-img">
                                            <a href="#" class="js-popup-btn" data-id="remove-shop-header-image">
                                                <div class="upload__overlay btn-tertiary--gray">
                                                    <span>Remove Header Image</span>
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                <div class="privacy">
                                    <h4 class="privacy__hdr">Privacy Settings</h4>
                                    <div class="privacy__check checkbox-container">
                                        <input id="public" type="checkbox" name="public" value="1"@if (getFormFieldValue($shop, 'public')) checked @endif />
                                        <span class="checkbox-overlay"></span>
                                        <label for="public" class="checkbox-text">Show my profile to the public</label>
                                    </div>
                                    <div class="privacy__check checkbox-container">
                                        <input id="share_favourites" type="checkbox" name="share_favourites" value="1"@if (getFormFieldValue($shop, 'share_favourites')) checked @endif />
                                        <span class="checkbox-overlay"></span>
                                        <label for="share_favourites" class="checkbox-text">Share my favourites</label>
                                    </div>
                                </div>

                                <div class="username input-group">
                                    <h4 class="username__hdr">Username* <span>(Must be unique and contain no space)</span></h4>
                                    <input type="text" name="username" value="{{ getFormFieldValue($shop, 'username') }}" class="username__input field-secondary" />
                                </div>
                                <button class="update-options-side__btn btn-primary btn-primary--minor" type="submit">
                                    <span>Save Changes</span>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="image_path" value="{{ $shop->image_path }}" />
                        <input type="hidden" name="header_image_path" value="{{ $shop->header_image_path }}" />
                    </form>
                </section>
            </div>

        </div>
    </div>

</main>

<div class="js-popup popup remove-shop-image">
    <div class="darkenator js-popup-cancel"></div>
    <div class="upload-popup">
        <div class="row">
            <div class="col-xs-12">
                <span class="js-popup-cancel upload-popup__cancel">&#10060;</span>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <p class="text-center">Are you sure you want to remove your shop Image?</p>
                <div class="buttons">
                    <div class="minor">
                        <a class="btn-tertiary--gray btn-primary--warning pull-right"
                            href="{{ route('edit.user.delete.shop.image', ['image' => 'image_path' ]) }}">
                                <span>Delete</span>
                        </a>
                    </div>

                    <div class="minor">
                        <a class="btn-tertiary--gray pull-right js-popup-cancel pull-right"
                           href="{{ route('edit.user.delete.shop.image', ['image' => 'image_path' ]) }}">
                            <span>Cancel</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="js-popup popup remove-shop-header-image">
    <div class="darkenator js-popup-cancel"></div>
    <div class="upload-popup">
        <div class="row">
            <div class="col-xs-12">
                <span class="js-popup-cancel upload-popup__cancel">&#10060;</span>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <p class="text-center">Are you sure you want to remove your shop Header?</p>
                <div class="buttons">

                    <div class="minor">
                        <a class="btn-tertiary--gray btn-primary--warning pull-right"
                           href="{{ route('edit.user.delete.shop.image', ['image' => 'header_image_path' ]) }}">
                            <span>Delete</span>
                        </a>
                    </div>

                    <div class="minor">
                        <a class="btn-tertiary--gray pull-right js-popup-cancel pull-right"
                           href="{{ route('edit.user.delete.shop.image', ['image' => 'image_path' ]) }}">
                            <span>Cancel</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes.footer')
@stop
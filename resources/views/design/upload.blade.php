@section('page_title', 'Design your own fabric | Upload Design')
@section('page_class', 'page-upload')
@section('meta_description', 'With Fashion Formula, keen artists can upload their own unique designs and earn commission for any sales made. Like the sound of it? Join our community now!')
@section('meta_keywords', '')

@extends('layouts.master')

@section('content')
@include('includes.mobile-nav')
@include('includes.header')

<main>
    <div class="container container-global">
        <div class="row">

            <div class="col-xs-12 no-pad container-dotted-pattern">
                <div class="row">

                    <div class="col-md-9 col-md-push-3 col-sm-12">
                        <section class="upload-design" data-match="container-not-mobile">

                            <div class="row">
                                @include('includes.flash')
                                <div class="col-sm-6 col-sm-push-6 col-xs-12" data-match="height">
                                    <form id="form-upload-design" action="{{ Request::url() }}" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="upload-design-textarea">
                                            <h2 class="upload-design-textarea__hdr hdr-section--minor">Upload your design</h2>
                                            <p class="upload-design-textarea__ordered">1. Select your file</p>
                                            <p class="upload-design-textarea__para">Acceptable formats: TIFF, JPG, PNG, GIF. File must be less than 40MB (150 Dpi recommended)</p>
                                            <p class="upload-design-textarea__para" style="color: #E71B23">Your file will remain private and confidential unless you actively choose to create a store and sell it online</p>
                                            <div class="upload">
                                                <input class="upload__btn" type="file" name="file" accept="image/*" />
                                                <div class="upload__overlay btn-tertiary--gray"><span>Choose File</span></div>
                                            </div>
                                            <span class="file-name"></span>
                                        </div>
                                        <div class="upload-design-textarea">
                                            <h2 class="upload-design-textarea__hdr hdr-section--minor">Confirm copyright</h2>
                                            <p class="upload-design-textarea__ordered">2. The legal bit - Protecting the IP rights of designers</p>
                                            <p class="upload-design-textarea__para">Fashion Formula supports the creativity of individual artist and designers. Uploading images that infringe on others Intellectual property rights, such as Copyright, Trademarks and design rights are a violation of our terms of service.</p>
                                            <div class="checkbox-container">
                                                <input id="rights" type="checkbox" name="permission" value="1" />
                                                <span class="checkbox-overlay"></span>
                                                <label for="rights" class="checkbox-text">I own the rights or have permission to use this image, and accept to adhere to Fashion Formula’s <a href="{{ route('view.privacy') }}" target="_blank">terms of service</a>.</label>
                                            </div>								
                                        </div>
                                        <div class="upload-design-textarea">
                                            <h2 class="upload-design-textarea__hdr hdr-section--minor">Upload your design</h2>
                                            <p class="upload-design-textarea__ordered">3. Happy with your design?</p>
                                            <p class="upload-design-textarea__para no-padding">Click below to upload your design to the site.</p>
                                            <button class="upload-design-textarea__btn btn-primary btn-upload-design" type="button">
                                                <span>Upload File</span>
                                            </button>
                                            <span class="icon-loading hidden"><div class="loader">Loading...</div></span>
                                            <p class="upload-design-textarea__label">Need help? <a href="{{ route('view.contact') }}">Send us an email</a> for assistance</p>							
                                        </div>
                                    </form>
                                </div>
                                <div class="col-sm-6 col-sm-pull-6 col-xs-12" data-match="height">
                                    <div class="upload-design-image">
                                    </div>
                                </div>								
                            </div>

                        </section>
                    </div>

                    <div class="col-md-3 col-md-pull-9 col-sm-12 hidden-xs" data-match="container-tablet-only">
                        <div class="row aside-boots">
                            <div class="col-sm-4 col-md-12 boot-style">
                                <!-- SIDE NAV LIST LINKS-->
                                @include('includes.design-tip-category-aside', ['categories' => getDesignTipCategories()])
                            </div>

                            <div class="col-sm-4 col-md-12 boot-style">						
                                <!-- SIDE NAV SOCIAL LINKS-->
                                <aside class="aside-social" data-match="height">
                                    <h2 class="aside-social__hdr hdr-section--minor">Connect</h2>
                                    <p class="aside-social__para para-side">Connect with the Fashion Formula community</p>
                                    <div class="aside-social-btns">
                                        <a href="{{ getSettingValue('social_media/facebook_link') }}" class="aside-social-btns__btn btn-social fb" target="_blank"></a>
                                        <a href="{{ getSettingValue('social_media/twitter_link') }}" class="aside-social-btns__btn btn-social tw" target="_blank"></a>
                                        <a href="{{ getSettingValue('social_media/pinterest_link') }}" class="aside-social-btns__btn btn-social pn" target="_blank"></a>
                                        <a href="{{ getSettingValue('social_media/instagram_link') }}" class="aside-social-btns__btn btn-social ig" target="_blank"></a>
                                    </div>
                                </aside>
                            </div>

                            <div class="col-sm-4 col-md-12 boot-style">	
                                <!-- SIDE NAV BLOG -->
                                <aside class="aside-blog" data-match="height">
                                    <h2 class="aside-blog__hdr hdr-section--minor">Blog</h2>
                                    <p class="aside-blog__para para-side">Tutorials, inspiration and competitions</p>
                                    <a href="{{ route('view.blog') }}" class="aside-blog__btn btn-tertiary--gray"><span>View More</span></a>
                                </aside>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

</main>

<span data-id="design-upload-popup" class="js-popup-btn btn-design-upload-popup hidden"></span>
<div class="js-popup popup design-upload-popup">
    <div class="darkenator js-popup-cancel"></div>
    <div class="upload-popup">
        <div class="row">
            <div class="col-xs-12">
                <span class="js-popup-cancel upload-popup__cancel">&#10060;</span>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <p class="text-center">Hang in there folks ...  It shouldn't take more than a couple of minutes to create your design.</p>
            </div>      
        </div>
    </div>
</div>

@include('includes.footer')
@stop
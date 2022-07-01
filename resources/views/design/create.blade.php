@section('page_title', 'Create Custom Fabric, Wallpaper &amp; More')
@section('page_class', 'confirmation-page')
@section('meta_description', 'Creating your own bespoke fabric, wallpaper, gift wrap & accessories has never been simpler. To get started, visit our website and discover your creative flair.')
@section('meta_keywords', '')

@extends('layouts.master')

@section('content')
@include('includes.mobile-nav')
@include('includes.header')

<main>

    <div class="container container-global">
        <div class="row">

            <div class="col-xs-12 container-dotted-pattern">
                <div class="row">

                    <!-- FEATURED BANNER -->
                    <div class="row">
                        <div class="col-xs-12">
                            <section class="featured-banner featured-banner--create-design">
                                <h1 class="featured-banner__hdr">Create</h1>
                                <p class="featured-banner__para">Create your own bespoke fabrics and wallpaper ...it's simple</p>
                            </section>
                        </div>
                    </div>

                    <!-- FABRIC INFO AND IMAGE -->
                    <section class="info-image">
                        @foreach ($categories as $key => $category)
                        <div class="row @if ($key & 1) even @else odd @endif">
                            <div class="col-xs-12">

                                <div class="col-sm-6 @if ($key & 1) even-col col-sm-push-6 @else odd-col @endif">
                                    <div class="info-image-textarea @if ($key & 1) -right- @else -left- @endif">
                                        <h2 class="info-image-textarea__hdr">{{ $category->title }}</h2>
                                        <div class="info-content">{!! $category->description !!}</div>

                                        <div class="row text-center-xs">
                                            <div class="col-lg-6">
                                                <a class="info-image-textarea__btn -left- btn-primary btn-primary--minor" href="{{ route('view.shop.all', ['category[]' => $category->id]) }}"><span>Browse Existing Designs</span></a>
                                            </div>
                                            <div class="col-lg-6">
                                                <a class="info-image-textarea__btn -right- btn-tertiary" href="{{ route('view.products') }}#{{ $category->identifier }}-container"><span>Our {{ $category->title }}</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 @if ($key & 1) even-col col-absolute-left-xs @else odd-col col-absolute-right-xs @endif">
                                    <div class="info-image-cta js-full-mobile-only-half js-full-height" style="background-image: url('{{ asset($category->image_path) }}');">
                                        <div class="vertical-outer background-darken">
                                            <div class="vertical-inner">
                                                <h3 class="info-image-cta__hdr">Upload {{ $category->title }} Design</h3>
                                                <a class="info-image-cta__btn btn-secondary" href="{{ route('view.design.upload') }}"><span>Get Started</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        @endforeach
                    </section> 					

                    <!-- VIDEO SECTION -->
                    <section class="info-video hidden-xs">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="info-video-player video-player">
                                    <video id="myVideo" class="info-video-player__video">
                                        <source src="" type="video/mp4">
                                    </video>
                                    <span class="js-play info-video-player__play paused"></span>
                                    <span class="js-background info-video-player__darken fade"></span>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="info-video-textarea">
                                    <h2 class="info-video-textarea__hdr">Fashion Formula</h2>
                                    <p class="info-video-textarea__para">Create your own unique fabrics, wallpaper & gift wraps or select a design from thousands available, created by our highly talented design community. Upload your designs to sell for commission and become part of the community today.</p>
                                    <a href="{{ route('view.shop.all') }}" class="info-video-textarea__btn btn-primary btn-primary--minor"><span>Browse Existing Fabrics</span></a>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

        </div>
    </div>

</main>

@include('includes.footer')
@stop
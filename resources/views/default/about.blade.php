@section('page_title', 'About Us')
@section('page_class', 'page-about')

@extends('layouts.master')

@section('content')
@include('includes.mobile-nav')
@include('includes.header')

<main>

    <div class="container container-global">
        <div class="row">

            <div class="col-xs-12 container-dotted-pattern">
                <div class="row">

                    <div class="row">
                        <div class="col-xs-12">
                            <section class="featured-banner featured-banner--about" style="background-image: url({{ $aboutUs->header_image }})">
                                <h1 class="featured-banner__hdr">{{ $aboutUs->header_title }}</h1>
                                <p class="featured-banner__para">{!! $aboutUs->header_content !!}</p>
                            </section>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <section class="featured-textarea">
                                <h1 class="featured-textarea__hdr featured-textarea__hdr--curve-line hdr-section">{{ $aboutUs->section_1_title }}</h1>
                                <p class="featured-textarea__para para-main">{!! $aboutUs->section_1_content !!}</p>
                            </section>
                        </div>
                    </div>

                    <section class="info-image info-image--slant">
                        <div class="row odd">
                            <div class="col-xs-12">

                                <div class="col-sm-5 odd-col">
                                    <div class="info-image-textarea -left-">
                                        <h2 class="info-image-textarea__hdr">{{ $aboutUs->section_2_title }}</h2>
                                        <p class="info-image-textarea__para">{!! $aboutUs->section_2_content !!}</p>
                                        <div class="row text-center-xs">
                                            <div class="col-lg-6">
                                                <a class="info-image-textarea__btn -left- btn-primary btn-primary--minor" href="{{ $aboutUs->section_2_button_url }}"><span>{{ $aboutUs->section_2_button_title }}</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-7 odd-col col-absolute-right-xs">
                                    <div class="info-image-cta info-image-cta--img1 js-full-mobile-only-half js-full-height">
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row even">
                            <div class="col-xs-12">

                                <div class="col-sm-6 even-col col-sm-push-6">
                                    <div class="info-image-textarea -right-">
                                        <h2 class="info-image-textarea__hdr">{{ $aboutUs->section_3_title }}</h2>
                                        <p class="info-image-textarea__para">{!! $aboutUs->section_3_content !!}</p>
                                        <div class="row text-center-xs">
                                            <div class="col-lg-6">
                                                <a class="info-image-textarea__btn -left- btn-primary btn-primary--minor" href="{{ $aboutUs->section_3_button_url }}"><span>{{ $aboutUs->section_3_button_title }}</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 even-col col-absolute-left-xs">
                                    <div class="info-image-cta info-image-cta--img2 js-full-mobile-only-half js-full-height"></div>
                                </div>

                            </div>
                        </div>
                    </section>

                    <!-- VIDEO SECTION -->
                    <section class="info-video info-video--centered">
                        <div class="row">
                            <div class="col-xs-12">
                                <h2 class="info-video-textarea__hdr">{{ $aboutUs->section_4_title }}</h2>
                            </div>
                            <div class="col-xs-12">
                                <div class="info-video-player">
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <iframe class="embed-responsive-item" src="{{ $aboutUs->section_4_video }}" allowfullscreen></iframe>
                                    </div>
                                </div>
                                <div class="info-video-player video-player hidden">
                                    <video id="myVideo" class="info-video-player__video">
                                        <source src="" type="video/mp4">
                                    </video>
                                    <span class="js-play info-video-player__play paused"></span>
                                    <span class="js-background info-video-player__darken fade"></span>
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

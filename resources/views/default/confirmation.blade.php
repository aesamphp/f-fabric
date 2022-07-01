@section('page_title', 'Thank you for registering')
@section('page_class', 'confirmation-page')

@extends('layouts.master')

@section('content')
@include('includes.mobile-nav')
@include('includes.header')

<main>
    <div class="container container-global">
        <div class="row">
            <div class="container-dotted-pattern col-xs-12 no-pad">
                <div class="extra-margin">
                    <section class="confirmation">
                        <div class="row">
                            <div class="col-xs-12">
                                <h1 class="confirmation__hdr hdr-section">Thank you for registering with Fashion Formula</h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-12 border-right">
                                <div class="confirmation-image confirmation-image--img1">
                                    <div class="confirmation-image-title">
                                        <div class="vertical-outer">
                                            <div class="vertical-inner">
                                                <h2 class="confirmation-image-title__hdr">Manage your designs</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('view.user.designs') }}" class="confirmation-image__btn btn-primary"><span>My Designs</span></a>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xs-12">
                                <div class="confirmation-image confirmation-image--img2">
                                    <div class="confirmation-image-title">
                                        <div class="vertical-outer">
                                            <div class="vertical-inner">
                                                <h2 class="confirmation-image-title__hdr">Set up shop details</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('edit.user.shop') }}" class="confirmation-image__btn btn-primary"><span>Update my shop</span></a>
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
@section('page_title', 'Custom Printed Fabric, Gift Wrap &amp; More')
@section('page_class', 'fabric-landing')
@section('meta_description', 'At Fashion Formula, we have the ability to print on a range of bases, including wallpaper and fabric. Explore our range of products on our website here.')
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
                    <div class="col-xs-12">

                        <section class="featured-tiles">
                            <h1 class="featured-tiles__hdr">Explore our products</h1>
                            <p class="featured-tiles__para">Choose from our large range of wallpapers, fabrics and gift wrap to find the ideal material for all your creative needs.</p>

                            <div class="sly-carousel sly-carousel-single sly-mobile-only container-single-tiles clearfix">
                                <div class="sly-content">
                                    @foreach ($categories as $category)
                                    <div class="sly-item col-md-3 col-sm-6 boot-style">
                                        <div class="single-tile js-full-mobile-only-half js-full-height" style="background-image: url('{{ asset($category->image_path) }}');">
                                            <div class="vertical-outer">
                                                <div class="vertical-inner">												
                                                    <h2 class="single-tile__hdr">{{ $category->title }}</h2>
                                                    <p class="single-tile__para">{{ $category->excerpt }}</p>
                                                    <a href="#{{ $category->identifier }}-container" class="single-tile__btn btn-primary btn-primary--minor"><span>View {{ $category->title }}</span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach	
                                </div>
                                <div class='sly-bullets'></div>																							
                            </div>
                        </section>
                    </div>
                </div>
                
                @foreach ($categories as $category)
                <div id="{{ $category->identifier }}-container" class="container-product-details">
                    <section class="featured-section-title featured-section-title--{{ $category->identifier }} mar-btm">
                        <h2 class="featured-section-title__hdr minor-center">View our range of {{ strtolower($category->title) }} below</h2>
                    </section>
                    
                    @foreach ($category->cmsProducts as $product)
                    <section class="js-image-container product-details product-details--first-of-type clearfix" data-match="container-not-tablet">
                        <div class="col-md-5 col-sm-12" data-match="height">
                            <div class="image-main js-full-height js-full-mobile-only-half">
                                <div class="js-image-main product-details-image" style="background-image:url('{{ asset($product->image1_path) }}');"></div>
                                <div class="js-image-main product-details-image" style="background-image:url('{{ asset($product->image2_path) }}');"></div>
                                <div class="js-image-main product-details-image" style="background-image:url('{{ asset($product->image3_path) }}');"></div>
                            </div>
                        </div>

                        <div class="col-md-7 col-sm-12" data-match="height">
                            <div class="product-details-textarea">
                                <h2 class="product-details-textarea__title hdr-section">{{ $product->title }}</h2>
                                
                                <div class="product-lists">{!! $product->content !!}</div>

                                <div class="product-thumbs">
                                    <div class="row">
                                        <div class="col-lg-8 col-sm-7 boot-style">
                                            <div class="product-thumbs-images"> 										
                                                <div class="js-image-thumb product-thumbs-images__img" style="background-image:url('{{ asset($product->image1_path) }}');"></div>
                                                <div class="js-image-thumb product-thumbs-images__img" style="background-image:url('{{ asset($product->image2_path) }}');"></div>
                                                <div class="js-image-thumb product-thumbs-images__img" style="background-image:url('{{ asset($product->image3_path) }}');"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-5">
                                            <a href="{{ route('view.shop.sample.books') }}" class="product-thumbs__btn btn-primary btn-primary--minor"><span>Order Samples</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    @endforeach
                    
                </div>
                @endforeach
                
            </div>
        </div>
    </div>

</main>

@include('includes.footer')
@stop
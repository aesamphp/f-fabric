@section('page_title', $page->title)
@section('page_class', 'custom-page')
@section('meta_description', $page->meta_description)

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
                <section class="featured-banner" style="background-image: url({{ asset($page->image_path) }})">
                  <h1 class="featured-banner__hdr">{{ $page->title }}</h1>
                </section>
              </div>
            </div>

            <!-- ORDERS AND SALES -->
            <div class="row">
              <div class="col-xs-12">

                <section class="faqs">
                  <div class="faqs-featured">
                    <div class="row">
                      <div class="col-xs-12">
                        <div class="answers answers--no-aside page-content">{!! $page->content !!}</div>
                      </div>
                    </div>
                  </div>
                </section>

              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

  </main>

  @include('includes.footer')
@stop
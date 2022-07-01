@section('page_title', 'Manipulate Design')
@section('page_class', 'page-edit')

@extends('layouts.master')

@section('content')
  @include('includes.mobile-nav')
  @include('includes.header')

  <main>

    <div class="container container-global">
      <div class="row">

        <div class="col-xs-12 no-pad container-dotted-pattern">
          @include('includes.flash')
          <div class="row">
            <div class="col-lg-9 col-lg-push-3 no-pad clearfix design-selected-options-wrapper">
              <div class="col-lg-7 col-md-6 col-sm-12 no-pad">

                <section class="design-selected add-style">
                  <div class="design-selected-image center-block loading-container">
                    <div class="icon-loading">
                      <div class="loader">Loading...</div>
                      <p class="para-main text-center">Preview Loading...<br/>It can take up to a minute...</p>
                    </div>
                  </div>
                  @include('design.design-mask-buttons')
                </section>
              </div>

              <div class="col-lg-5 col-md-6 col-sm-12 no-pad">
                <section class="design-options">
                  <div class="design-options-tabs clearfix">
                    <ul class="nav nav-tabs" role="tablist">
                      @foreach ($categories as $key => $category)
                        <li class="col-xs-3 tab-single @if (isset($basket)) @if ($basket->category_id == $category->id) active @endif @elseif ($key === 0) active @endif"
                            data-template="manipulate-tab-content" @if (isset($basket)) data-basket="{{ $basket->id }}"@endif>
                          <a href="#" data-id="{{ $category->id }}"
                             data-url="{{ route('view.category.tab.content', ['id' => $category->id]) }}">{{ $category->title }}</a>
                        </li>
                      @endforeach
                    </ul>
                  </div>
                  <form class="ajax-add-to-cart-form" method="POST" autocomplete="off"
                        action="{{ isset($basket) ? route('update.basket.item', ['id' => $basket->id]) : route('store.basket.item') }}">
                    {{ csrf_field() }}
                    @if (isset($basket))
                      {{ method_field('PATCH') }}
                    @endif
                    <div class="tab-content"></div>
                    <input type="hidden" name="design_saved" value="0"/>
                    <input type="hidden" name="colour_atlas" value="0"/>
                    <input type="hidden" name="sample_book" value="0"/>
                    <input type="hidden" name="plain_fabric" value="0"/>
                    <input id="design_type_id" type="hidden" name="design_type_id"/>
                    <input type="hidden" name="design_request_public" value="0"/>
                  </form>
                </section>
              </div>
            </div>

            <div class="col-lg-3 col-lg-pull-9 col-sm-12" data-match="container-tablet-only">
              <div class="row aside-boots">
                <div class="col-sm-4 col-lg-12 boot-style">
                  <!-- SIDE NAV LIST LINKS-->
                  @include('includes.design-tip-category-aside', ['categories' => getDesignTipCategories()])
                </div>

                <div class="col-sm-4 col-lg-12 boot-style">
                  <!-- SIDE NAV SOCIAL LINKS-->
                  <aside class="aside-social" data-match="height">
                    <h2 class="aside-social__hdr hdr-section--minor">Connect</h2>
                    <p class="aside-social__para para-side">Connect with the Fashion Formula community</p>
                    <div class="aside-social-btns">
                      <a href="{{ getSettingValue('social_media/facebook_link') }}"
                         class="aside-social-btns__btn btn-social fb" target="_blank"></a>
                      <a href="{{ getSettingValue('social_media/twitter_link') }}"
                         class="aside-social-btns__btn btn-social tw" target="_blank"></a>
                      <a href="{{ getSettingValue('social_media/pinterest_link') }}"
                         class="aside-social-btns__btn btn-social pn" target="_blank"></a>
                      <a href="{{ getSettingValue('social_media/instagram_link') }}"
                         class="aside-social-btns__btn btn-social ig" target="_blank"></a>
                    </div>
                  </aside>
                </div>

                <div class="col-sm-4 col-lg-12 boot-style">
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

          <!-- VIDEO SECTION -->
          <div class="row">
            <div class="col-xs-12">

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
                      <p class="info-video-textarea__para">Create your own unique fabrics, wallpaper & gift wraps or
                        select a design from thousands available, created by our highly talented design community.
                        Upload your designs to sell for commission and become part of the community today.</p>
                      <a href="{{ route('view.shop') }}" class="info-video-textarea__btn btn-primary"><span>Browse Existing Fabrics</span></a>
                    </div>
                  </div>
                </div>
              </section>
            </div>
          </div>

        </div>

      </div>
    </div>

  </main>

  @include('includes.footer')
@stop

@section('end_body')
  @include('design.manipulate-js')
@stop
@section('page_title', 'Edit My Design')
@section('page_class', 'page-edit-my-designs')


@extends('layouts.master')

@section('content')
@include('includes.mobile-nav')
@include('includes.header') 	

<main>

    <div class="container container-global">
        <div class="row">

            <div class="col-xs-12 container-dotted-pattern no-pad">
                @include('includes.flash')
                <!-- MANIPULATE DESIGN SECTION -->
                <div class="row" data-match="container-widescreen-only">
                    <div class="col-md-9 col-md-push-3 no-pad clearfix">
                        <div class="col-lg-7 col-md-12 col-sm-12" data-match="height">
                            <section class="design-selected add-style">
                                <div class="design-selected-image center-block loading-container" data-design="{{ $design->id }}">
                                    <div class="icon-loading">
                                        <div class="loader">Loading...</div>
                                        <p class="para-main text-center">Preview Loading...<br />It can take up to a minute...</p>
                                    </div>
                                </div>
                                @include('design.design-mask-buttons')
                            </section>
                        </div>

                        <div class="col-lg-5 col-md-12 col-sm-12" data-match="height">
                            <section class="design-options">
                                <div class="design-options-tabs clearfix">
                                    <ul class="nav nav-tabs" role="tablist">
                                        @foreach ($categories as $key => $category)
                                        <li class="col-xs-3 tab-single @if ($basket) @if ($basket->category_id == $category->id) active @endif @elseif ($key === 0) active @endif" data-design="{{ $design->id }}" data-template="edit-design-tab-content"@if ($basket) data-basket="{{ $basket->id }}"@endif>
                                            <a href="#" data-id="{{ $category->id }}" data-url="{{ route('view.category.tab.content', ['id' => $category->id]) }}">{{ $category->title }}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <form class="ajax-add-to-cart-form" method="POST"@if ($basket) action="{{ route('update.basket.item', ['id' => $basket->id]) }}"@else action="{{ route('store.basket.item') }}"@endif autocomplete="off">
                                    {{ csrf_field() }}
                                    @if ($basket)
                                    {{ method_field('PATCH') }}
                                    @endif
                                    <div class="tab-content"></div>
                                    <input type="hidden" name="design_saved" value="1" />
                                    <input type="hidden" name="design_id" value="{{ $design->id }}" />
                                    <input type="hidden" name="colour_atlas" value="0" />
                                    <input type="hidden" name="sample_book" value="0" />
                                    <input type="hidden" name="plain_fabric" value="0" />
                                    <input id="design_type_id" type="hidden" name="design_type_id" />
                                    <input id="design_request_public" type="hidden" name="design_request_public" value="0" />
                                </form>
                            </section>
                        </div>
                    </div>

                    <div class="col-md-3 col-md-pull-9 col-sm-12" data-match="container-tablet-only">
                        <div class="row aside-boots">
                            <div class="col-sm-4 col-md-12 boot-style hidden-xs">
                                <!-- SIDE NAV LIST LINKS-->
                                @include('includes.design-tip-category-aside', ['categories' => getDesignTipCategories(4)])
                            </div>

                            <div class="col-sm-4 col-md-12 boot-style">						
                                <aside class="aside-checklist section-fill section-fill--aside" data-match="height">
                                    <h3 class="aside-checklist__hdr hdr-section--minor">Sell or Display</h3>
                                    
                                    <div class="aside-checklist__check checkbox-container">
                                        <input id="design_private" type="radio" name="design_public" value="0"@if ($design->isPrivate()) checked @endif />
                                        <span class="checkbox-overlay"></span>
                                        <label for="design_private" class="checkbox-text text-red">Don't show my designs to public (Private)</label>
                                    </div>

                                    <div class="aside-checklist__check checkbox-container">
                                        <input id="design_public_false" type="radio" name="design_public" value="0"@if (!$design->isPrivate()) checked @endif />
                                        <span class="checkbox-overlay"></span>
                                        <label for="design_public_false" class="checkbox-text text-yellow">Show in my Design Gallery only (Not for Sale)</label>
                                    </div>

                                    <div class="aside-checklist__check checkbox-container">
                                        @if ($design->hasPurchasedSwatch())
                                        <input id="design_public_true" type="radio" name="design_public" value="1"@if ($design->isPublic()) checked @endif />
                                        @else
                                        <input id="public_popup" class="js-popup-btn btn-sell-public-popup" data-id="sell-public-popup" type="radio" name="public_popup" value="1" />
                                        @endif
                                        <span class="checkbox-overlay"></span>
                                        <label for="{{ ($design->hasPurchasedSwatch()) ? 'design_public_true' : 'public_popup' }}" class="checkbox-text text-green">Sell to public in my Shop (requires a sample to be purchased first)</label>
                                    </div>	                          					
                                </aside>									
                            </div>

                            <div class="col-sm-4 col-md-12 boot-style hidden-xs">	
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

                <!-- MARKETING AND SELLING -->
                <div class="row">
                    <div class="col-xs-12">
                        
                        <form id="design-edit-form" method="POST" action="{{ route('view.edit.design', ['id' => $design->id]) }}">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <input type="hidden" name="type_id" value="{{ getFormFieldValue($design, 'type_id') }}" />
                            <input type="hidden" name="dpi" value="{{ getFormFieldValue($design, 'dpi') }}" />
                            <input id="private" type="hidden" name="private" value="{{ getFormFieldValue($design, 'private') }}" />
                            <input id="public" type="hidden" name="public" value="{{ getFormFieldValue($design, 'public') }}" />
                            <input id="colours" type="hidden" name="colours" value="{{ $design->getColoursString() }}" />
                            <section class="edit-options">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h2 class="edit-options__hdr hdr-section--minor">Marketing &amp; selling</h2>
                                    </div>

                                    <div class="col-sm-6 col-xs-12">
                                        <div class="edit-options-primary">

                                            <div class="grouped-input">
                                                <label for="title" class="grouped-input__hdr hdr-section">Product Name* (A-Z,0-9 and - only)</label>
                                                <input id="title" type="text" name="title" value="{{ getFormFieldValue($design, 'title') }}" class="grouped-input__text field-primary" placeholder="This name will display under the image in the shop" />
                                            </div>
                                            <div class="grouped-input">
                                                <label for="description" class="grouped-input__hdr hdr-section">Description*</label>
                                                <textarea class="grouped-input__text field-primary" placeholder="Describe your image and your inspirations behind it" maxlength="128" id="description" name="description" cols="30" rows="5">{{ getFormFieldValue($design, 'description') }}</textarea>
                                            </div>
                                            <div class="grouped-input">
                                                <label for="additional_details" class="grouped-input__hdr hdr-section">Additional Details</label>
                                                <textarea class="grouped-input__text field-primary" placeholder="Tell us what product your design was particularly designed in mind for" maxlength="128" name="additional_details" id="additional_details" cols="30" rows="5">{{ getFormFieldValue($design, 'additional_details') }}</textarea>
                                            </div>
                                            <div class="grouped-input">
                                                <label class="grouped-input__hdr hdr-section">Product Thumbnail</label>
                                                @foreach ($thumbnailSizeOptions as $option)
                                                <div class="grouped-input-thumb">
                                                    <img src="{{ asset('images/thumb-full.png') }}" alt="Image" />
                                                    <div class="grouped-input-thumb__check radio-container">
                                                        <input id="thumbnail-size-{{ $option['id'] }}" type="radio" name="thumbnail_size" value="{{ $option['id'] }}"@if ($design->thumbnail_size === $option['id']) checked @endif />
                                                        <span class="checkbox-overlay"></span>
                                                        <label for="thumbnail-size-{{ $option['id'] }}" class="checkbox-text hdr-input-type">{{ $option['title'] }}</label>
                                                    </div>	
                                                </div>
                                                @endforeach
                                            </div>
                                            <div class="grouped-input">
                                                <label class="grouped-input__hdr hdr-section" for="weekly_contest_id">Add To Weekly Contest?</label>
                                                <select id="weekly_contest_id" class="auto-select" name="weekly_contest_id" data-value="{{ $design->weekly_contest_id }}">
                                                    <option value="">Please Select</option>
                                                    {!! generateDropdownOptions($weeklyContests->toArray(), 'id', 'title') !!}
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-12">
                                        <div class="edit-options-secondary">

                                            <div class="grouped-input vertical-padding clearfix">
                                                <h3 class="grouped-input__hdr hdr-section">Additional Images <span>(max 4 images)</span></h3>
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        <p class="grouped-input__subhdr hdr-section">Upload a file</p>
                                                        <p class="grouped-input__para selected-file-name">No file selected.</p>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <div class="upload minor">
                                                            <input id="file-input" class="upload__btn ajax-file-upload" type="file" name="file" data-url="{{ route('upload.additional.image', ['id' => $design->id]) }}" />
                                                            <div class="upload__overlay btn-tertiary--gray"><span>Choose File</span></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="container-image-preview">
                                                    @foreach ($design->additionalImages as $image)
                                                    <div class="js-image-preview image-preview active-thumb">
                                                        <span class="js-delete delete"></span>
                                                        <img src="{{ asset($image->path) }}" class="img-responsive center-block" />
                                                    </div>
                                                    <input type="hidden" name="additionalImages[]" value="{{ $image->path }}" />
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="js-label-input grouped-input">
                                                <label class="grouped-input__hdr hdr-section" for="labels">Labels</label>
                                                <p class="grouped-input__para">Please add in tags below that best describe your product. Enter one at a time and press "Enter" key.</p>
                                                <input class="js-text grouped-input__text field-primary" id="labels" type="text" placeholder="Label Name - press enter after each label to save" maxlength="20" />
                                                <input type="hidden" name="labels" value="{{ $design->getLabelsString(',') }}" />
                                                @foreach ($design->getLabels() as $label)
                                                <span class="js-tag grouped-input__label tag">
                                                    {{ $label->title }}
                                                    <span class="js-delete delete"></span>
                                                </span>
                                                @endforeach
                                            </div>

                                            <div class="js-label-input grouped-input">
                                                <label class="grouped-input__hdr hdr-section" for="collection_labels">Collection Labels</label>
                                                <p class="grouped-input__para">Please add in collection labels below to assign to your product. Enter one at a time and press "Enter" key.</p>
                                                <input class="js-text grouped-input__text field-primary" id="collection_labels" type="text" placeholder="Collection Name - press enter after each collection to save" maxlength="20" />
                                                <input type="hidden" name="collection_labels" value="{{ $design->getCollectionLabelsString(',') }}" />
                                                @foreach ($design->getCollectionLabels() as $label)
                                                <span class="js-tag grouped-input__label tag">
                                                    {{ $label->title }}
                                                    <span class="js-delete delete"></span>
                                                </span>
                                                @endforeach
                                            </div>	

                                            <div class="grouped-input">
                                                <label class="grouped-input__hdr hdr-section">Colours</label>
                                                <span class="js-spectrum-remove remove"></span>
                                                <p class="grouped-input__para">Please add upto 4 colours for this procuts using the swatches below.</p>
                                                <div class="js-spectrum-container colours">
                                                    <div class="js-colour-swatches colour-swatches">
                                                        @forelse ($design->colours as $colour)
                                                        <div class="js-spectrum single-colour">
                                                            <input class="js-colour" type="text" value="{{ $colour->value }}" />
                                                            <div class="js-colour-value single-value">{{ $colour->value }}</div>	
                                                        </div>
                                                        @empty
                                                        <div class="js-spectrum single-colour">
                                                            <input class="js-colour" type="text" value="#000000" />
                                                            <div class="js-colour-value single-value">#000000</div>	
                                                        </div>
                                                        @endforelse
                                                    </div>												
                                                    <div class="js-spectrum-add single-colour">
                                                        <span class="js-text single-colour__para hdr-section--minor">
                                                            + Add Another Colour
                                                        </span>
                                                    </div>						
                                                </div>	
                                            </div>
                                            
                                            <div class="grouped-input">
                                                <label class="grouped-input__hdr hdr-section">Designed For</label>
                                                @foreach ($categories as $category)
                                                <div class="grouped-input-thumb">
                                                    <div class="grouped-input-thumb__check radio-container">
                                                        <input id="available-categoy-{{ $category->identifier }}" type="checkbox" name="design_category[]" value="{{ $category->id }}"@if (in_array($category->id, $design->getCategoryIds())) checked @endif />
                                                        <span class="checkbox-overlay"></span>
                                                        <label for="available-categoy-{{ $category->identifier }}" class="checkbox-text hdr-input-type">{{ $category->title }}</label>
                                                    </div>	
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12">
                                        <div class="edit-options-submit">
                                            <button class="edit-options-submit__btn btn-primary btn-primary--minor" type="submit"><span>Save my design</span></button>
                                        </div>
                                    </div>								
                                </div>
                            </section>
                        </form>

                    </div>
                </div>

                <!-- VIDEO SECTION -->
                <div class="row">
                    <div class="col-xs-12">

                        <section class="info-video">
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
                                        <a href="{{ route('view.shop.all') }}" class="info-video-textarea__btn btn-primary"><span>Browse Existing Fabrics</span></a>
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

<div class="js-popup popup sell-public-popup">
    <div class="darkenator js-popup-cancel"></div>
    <div class="upload-popup">
        <div class="row">
            <div class="col-xs-12">
                <span class="js-popup-cancel upload-popup__cancel">&#10060;</span>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <p class="text-center">Your design will be displayed to the public after you have purchased a sample or any product. Make sure to complete all fields below with tags and information in order increase your chances of a sale.</p>
                <br />
                <button class="upload-popup__send btn-primary btn-primary--minor btn-select-sample" type="button"><span>Select Sample</span></button>
            </div>      
        </div>
    </div>
</div>

@include('includes.footer')
@stop

@section('end_body')
@include('design.manipulate-js')
@stop
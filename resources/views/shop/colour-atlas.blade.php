@section('page_title', 'Custom Fabric Printing | Colour Atlas')
@section('page_class', 'shop-altlas-page')
@section('meta_description', 'Our colour atlas helps designers searching for the perfect colour; with over 1,000 colour codes, matching and selecting has never been simpler.')
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

                    <section class="colour-atlas">
                        
                        @include('includes.flash')
                        
                        <div class="row">
                            
                            <div class="col-md-6 col-sm-12">
                                <div class="colour-atlas-image"></div>
                            </div>
                            
                            <div class="col-md-6 col-sm-12">
                                <form class="ajax-add-to-cart-form" method="POST" action="{{ route('store.basket.item') }}" autocomplete="off">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="design_saved" value="0" />
                                    <input type="hidden" name="design_type_id" value="4" />
                                    <input type="hidden" name="category_id" value="{{ $category->id }}" />
                                    <input type="hidden" name="dpi" value="{{ getClassConstantValue('App\Models\DesignImage::DPI_ACTUAL_MIN') }}" />
                                    <input type="hidden" name="colour_atlas" value="1" />
                                    <input type="hidden" name="sample_book" value="0" />
                                    <input type="hidden" name="plain_fabric" value="0" />
                                    <input type="hidden" name="design_request_public" value="0" />
                                    <div class="col-xs-12 no-pad clearfix">
                                        <div class="colour-atlas-textarea">

                                            <h1 class="colour-atlas-textarea__hdr hdr-section">Colour Atlas</h1>

                                            <div class="atlas-dropdown">
                                                <label class="atlas-dropdown__label" for="product_id">1. Choose a type</label>
                                                <select class="atlas-dropdown__select" name="product_id" id="product_id">
                                                    @foreach ($category->products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="atlas-dropdown qty clearfix">
                                                <label class="atlas-dropdown__label" for="choose-fabric">2. Choose a material &amp; quantity</label>
                                                <div class="col-xs-12 col-sm-8 no-pad">
                                                    <div class="col-xs-10 no-pad-left">
                                                        <select class="atlas-dropdown__select input-fabric__dropdown"></select>
                                                    </div>
                                                    <div class="col-xs-2 no-pad">
                                                        <input type="tel" class="input-qty__dropdown number" name="quantity" value="1" placeholder="quantity" />
                                                    </div>
                                                </div>
                                            </div>	

                                            <p class="atlas-description">The colour atlas from Fashion Formula is designed to fit on a one meter of fabric and consists of over 1000 colours and their codes. It allows designers to see the colours on fabric or paper, and to select the colours to use in designs, useful for colour matching and selection.</p>								
                                        </div>
                                    </div>
                                    <div class="col-xs-12 clearfix no-pad">
                                        <div class="colour-atlas-total clearfix">
                                            <div class="col-md-6 col-sm-12 no-pad clearfix">
                                                <h4 class="input-price__hdr">Unit Price: {{ getCurrentCurrencySymbol() }}<span>0.00</span></h4>
                                                <h2 class="input-total__hdr colour-atlas-total__total hdr-section">TOTAL: {{ getCurrentCurrencySymbol() }}<span>0.00</span></h2>
                                            </div>	
                                            <div class="col-md-6 col-sm-12 no-pad clearfix">
                                                <button type="submit" class="colour-atlas-total__btn btn-primary btn-primary--minor"><span>Add to cart</span></button>
                                            </div>	
                                        </div>	
                                    </div>

                                    <div class="col-xs-12 clearfix no-pad">
                                        <div class="colour-atlas-download">
                                            <div class="col-sm-8 col-xs-12 no-pad">
                                                <div class="colour-atlas-download__para">Please note that the colour atlas does not represent all the colours possible to print but merely a good selection. Designs should be set in RGB to match the profile to ensure accurate colour matching.</div>
                                            </div>
                                            <div class="col-sm-4 col-xs-12 no-pad">
                                                <a href="{{ route('download.file', ['path' => 'downloads/Colour_Atlas.zip']) }}" class="colour-atlas-download__btn btn-tertiary"><span>Download</span></a>
                                            </div>
                                        </div>	
                                    </div>
                                </form>
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

@section('end_body')
<script type="text/javascript">
    $(function() {
        $.fn.getMaterialDropdown = function() {
            var $replaceSelect = $('select.input-fabric__dropdown'),
                ajaxURL = App.config.routes.baseURL + "/product/" + $('select#product_id').val() + "/material/dropdown";
            $.get(ajaxURL, function(response) {
                $replaceSelect.replaceWith(response);
                $('select#atlas-select-fabric').addClass('atlas-dropdown__select');
                App.functions.calculatePrice();
            }).fail(function(error) {
                alert(error.responseText);
            });
        };
        $('select#product_id').change($.fn.getMaterialDropdown);
        $.fn.getMaterialDropdown();
    });
</script>
@stop
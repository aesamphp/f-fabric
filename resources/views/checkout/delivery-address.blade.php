@section('page_title', 'Delivery Address')
@section('page_class', 'page-delivery-address')


@extends('layouts.master')

@section('content')
@include('includes.mobile-nav')
@include('includes.header') 	

<main>

    <div class="container container-global">
        <div class="row">

            <div class="col-xs-12 container-dotted-pattern no-pad">

                <!-- FEATURED BANNER -->
                <div class="row">
                    <div class="col-xs-12">
                        <section class="featured-banner featured-banner--details no-title">
                            <h1 class="featured-banner__hdr">Checkout</h1>
                        </section>
                    </div>
                </div>	

                <!-- CHECKOUT -->
                <form id="delivery-address-form" class="address-form" method="POST" action="{{ Request::url() }}">
                    {{ csrf_field() }}
                    <div class="checkout">
                        <div class="row">
                            <div class="col-xs-12">
                                @include('checkout.steps-nav')
                            </div>
                        </div>
                        
                        @include('includes.flash')
                        
                        <div class="row">
                            <div class="col-xs-12">
                                <section class="checkout-previous">
                                    <h2 class="checkout-previous__hdr hdr-section">Use Previous Address</h2>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-5 col-xs-12">
                                            <div class="checkout-previous-field">
                                                @if (count($user->addresses) > 0)
                                                <select id="previous-address">
                                                    <option value="">Please Select</option>
                                                    @foreach ($user->addresses as $address)
                                                    <option value="{{ $address->id }}">{{ $address->toString() }}</option>
                                                    @endforeach
                                                </select>
                                                @else
                                                <p>You don't have any address saved in your address list.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-8 col-sm-12">

                                <section class="checkout-input">
                                    <h2 class="checkout-input__hdr mandatory hdr-section">Delivery Address</h2>
                                    <div class="row">

                                        <div class="col-xs-12">
                                            <div class="checkbox-container">
                                                <input id="use-billing-address" type="checkbox" name="use_billing_address" value="1" />
                                                <span class="checkbox-overlay"></span>
                                                <label for="use-billing-address" class="checkbox-text">Use billing address</label>
                                            </div>                                            
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="checkout-input-field field-group">
                                                <label for="title">Title *</label>
                                                <select id="title" name="title" class="auto-select" data-value="{{ getFormFieldValue($deliveryAddress, 'title') }}">
                                                    <option value="">Please Select</option>
                                                    <option value="Mr">Mr</option>
                                                    <option value="Mrs">Mrs</option>
                                                    <option value="Miss">Miss</option>
                                                    <option value="Ms">Ms</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6">
                                            <div class="checkout-input-field field-group">
                                                <label for="first_name">First Name *</label>
                                                <input id="first_name" class="field-secondary field-secondary--input-central" type="text" name="first_name" value="{{ getFormFieldValue($deliveryAddress, 'first_name') }}" />
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="checkout-input-field field-group">
                                                <label for="last_name">Last Name *</label>
                                                <input id="last_name" class="field-secondary field-secondary--input-central" type="text" name="last_name" value="{{ getFormFieldValue($deliveryAddress, 'last_name') }}" />
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="checkout-input-field field-group">
                                                <label for="address_line1">Address Line 1 *</label>
                                                <input id="address_line1" class="field-secondary field-secondary--input-central" type="text" name="address_line1" value="{{ getFormFieldValue($deliveryAddress, 'address_line1') }}" />
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="checkout-input-field field-group">
                                                <label for="address_line2">Address Line 2</label>
                                                <input id="address_line2" class="field-secondary field-secondary--input-central" type="text" name="address_line2" value="{{ getFormFieldValue($deliveryAddress, 'address_line2') }}" />
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="checkout-input-field field-group">
                                                <label for="city">City/town *</label>
                                                <input id="city" class="field-secondary field-secondary--input-central" type="text" name="city" value="{{ getFormFieldValue($deliveryAddress, 'city') }}" />
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="checkout-input-field field-group">
                                                <label for="postcode">Zip/Postal Code *</label>
                                                <input id="postcode" class="field-secondary field-secondary--input-central" type="text" name="postcode" value="{{ getFormFieldValue($deliveryAddress, 'postcode') }}" />
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 input-field">
                                            <div class="checkout-input-field checkout-input-field--select field-group">
                                                <label for="state">State</label>
                                                <select id="state" name="state" class="auto-select select-state" data-value="{{ getFormFieldValue($deliveryAddress, 'state') }}">
                                                    <option value="">Please Select</option>
                                                    {!! generateDropdownOptions($states->toArray(), 'code', 'title') !!}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="checkout-input-field checkout-input-field--select field-group">
                                                <label for="country">Country *</label>
                                                <select id="country" name="country" class="auto-select select-country" data-value="{{ getFormFieldValue($deliveryAddress, 'country') }}">
                                                    <option value="">Please Select</option>
                                                    {!! generateDropdownOptions($countries->toArray(), 'code', 'title') !!}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="checkout-input-field field-group">
                                                <label for="phone">Phone Number </label>
                                                <input id="phone" class="field-secondary field-secondary--input-central" type="tel" name="phone" value="{{ getFormFieldValue($deliveryAddress, 'phone') }}" />
                                            </div>
                                        </div>
                                    </div>					
                                </section>
                            </div>
                        </div>
                        
                        <!-- DELIVERY OPTIONS -->
                        <div class="row">
                            <div class="col-xs-12">
                                <section class="delivery-options hidden">
                                    <h2 class="delivery-options__hdr hdr-section">Delivery Options</h2>
                                    <div class="delivery-options-inner block-loader">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <p class="delivery-options-inner__para text-center">Please Wait While We Retrieve Delivery Options</p>
                                                <span class="icon-loading center-block"><div class="loader">Loading...</div></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="delivery-options-inner block-options hidden"></div>
                                </section>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="checkout-previous-cta">
                                    <a href="{{ route('view.checkout.billing.address') }}" class="checkout-previous-cta__btn btn-primary btn-primary--no-border--thick"><span>Back</span></a>
                                    <button class="checkout-previous-cta__btn btn-primary btn-primary--no-border--thick" type="submit">
                                        <span>Next</span>
                                    </button>
                                </div>
                            </div>       
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>

</main>


@include('includes.footer')
@stop

@section('end_body')
<script type="text/javascript">
    App.config.routes.getBillingAddressURL = "{{ route('view.checkout.billing.address') }}";
    App.config.routes.getDeliveryOptionsURL = "{{ route('view.checkout.delivery.options') }}";
    App.config.routes.getAddressURL = "{{ route('view.checkout.previous.address') }}";
    $(function() {
        $('input#use-billing-address').click(function() {
            var $this = $(this),
                $form = $('form#delivery-address-form'),
                $selects = $form.find('select');
            if ($this.is(':checked')) {
                $.getJSON(App.config.routes.getBillingAddressURL, function(response) {
                    for (var index in response) {
                        $form.find('#' + index).val(response[index]).trigger('change');
                    }
                }).fail(function(error) {
                    alert(error.responseText);
                });
            } else {
                $form.trigger('reset');
                $selects.trigger('change');
            }
        });
        
        $('select#country').change(function() {
            var $this = $(this),
                $container = $('.delivery-options'),
                $loader = $container.find('.block-loader'),
                $options = $container.find('.block-options'),
                formData = {_token: App.config.csrfToken, country: $this.val()};
            if ($this.val()) {
                $options.empty().addClass('hidden');
                $loader.removeClass('hidden');
                $container.removeClass('hidden');
                $.post(App.config.routes.getDeliveryOptionsURL, formData, function(response) {
                    $loader.addClass('hidden');
                    $options.html(response).removeClass('hidden');
                }).fail(function(error) {
                    $loader.addClass('hidden');
                    alert(error.responseText);
                });
            } else {
                $container.addClass('hidden');
            }
        });
        
        @if (getFormFieldValue($deliveryAddress, 'country'))
        $('select#country').trigger('change');
        @endif
        
        App.functions.usePreviousAddress();
    });
</script>
@stop
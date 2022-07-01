@section('page_title', 'Billing Address')
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
                <form class="address-form" method="POST" action="{{ Request::url() }}">
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
                                    <h2 class="checkout-input__hdr mandatory hdr-section">Billing Address</h2>
                                    <div class="row">

                                        <div class="col-xs-12">
                                            <div class="checkout-input-field field-group">
                                                <label for="title">Title *</label>
                                                <select id="title" name="title" class="auto-select" data-value="{{ getFormFieldValue($billingAddress, 'title') }}">
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
                                                <input id="first_name" class="field-secondary field-secondary--input-central" type="text" name="first_name" value="{{ getFormFieldValue($billingAddress, 'first_name') }}" />
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="checkout-input-field field-group">
                                                <label for="last_name">Last Name *</label>
                                                <input id="last_name" class="field-secondary field-secondary--input-central" type="text" name="last_name" value="{{ getFormFieldValue($billingAddress, 'last_name') }}" />
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="checkout-input-field field-group">
                                                <label for="address_line1">Address Line 1 *</label>
                                                <input id="address_line1" class="field-secondary field-secondary--input-central" type="text" name="address_line1" value="{{ getFormFieldValue($billingAddress, 'address_line1') }}" />
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="checkout-input-field field-group">
                                                <label for="address_line2">Address Line 2</label>
                                                <input id="address_line2" class="field-secondary field-secondary--input-central" type="text" name="address_line2" value="{{ getFormFieldValue($billingAddress, 'address_line2') }}" />
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="checkout-input-field field-group">
                                                <label for="city">City/town *</label>
                                                <input id="city" class="field-secondary field-secondary--input-central" type="text" name="city" value="{{ getFormFieldValue($billingAddress, 'city') }}" />
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="checkout-input-field field-group">
                                                <label for="postcode">Zip/Postal Code *</label>
                                                <input id="postcode" class="field-secondary field-secondary--input-central" type="text" name="postcode" value="{{ getFormFieldValue($billingAddress, 'postcode') }}" />
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 input-field">
                                            <div class="checkout-input-field checkout-input-field--select field-group">
                                                <label for="state">State</label>
                                                <select id="state" name="state" class="auto-select select-state" data-value="{{ getFormFieldValue($billingAddress, 'state') }}">
                                                    <option value="">Please Select</option>
                                                    {!! generateDropdownOptions($states->toArray(), 'code', 'title') !!}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="checkout-input-field checkout-input-field--select field-group">
                                                <label for="country">Country *</label>
                                                <select id="country" name="country" class="auto-select select-country" data-value="{{ getFormFieldValue($billingAddress, 'country') }}">
                                                    <option value="">Please Select</option>
                                                    {!! generateDropdownFromArray($countries) !!}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="checkout-input-field field-group">
                                                <label for="phone">Phone Number </label>
                                                <input id="phone" class="field-secondary field-secondary--input-central" type="tel" name="phone" value="{{ getFormFieldValue($billingAddress, 'phone') }}" />
                                            </div>
                                        </div>
                                    </div>					
                                </section>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="checkout-previous-cta">
                                    <a href="{{ route('view.basket') }}" class="checkout-previous-cta__btn btn-primary btn-primary--no-border--thick"><span>Edit Cart</span></a>
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
    App.config.routes.getAddressURL = "{{ route('view.checkout.previous.address') }}";
    $(function() {
        App.functions.usePreviousAddress();
    });
</script>
@stop
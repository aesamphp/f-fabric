@section('page_title', 'Contact')
@section('page_class', 'page-contact')


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
                            <section class="featured-banner featured-banner--contact">
                                <h1 class="featured-banner__hdr">Contact Us</h1>
                                <p class="featured-banner__para">We're always on hand should you need us, don't hesitate to get in touch. We'd love to hear from you!</p>
                            </section>
                        </div>
                    </div>	

                    <!-- CONTACT AREA -->
                    <div class="row">
                        <section class="contact clearfix" data-match="container">
                            <div class="col-xs-12">@include('includes.flash')</div>
                            <div class="col-md-6">
                                <div class="contact-image" data-match="height">
                                    <div class="contact-image__img"></div>
                                </div>
                            </div>	

                            <div class="col-md-6 col-xs-12">
                                <div class="contact-form" data-match="height">
                                    <h2 class="contact-form__hdr">Get in touch</h2>
                                    <p class="contact-form__para">If you have any questions, please use the form below and we will get back to you. You can also call us at <a href="tel:+442036955442" style="display: inline-block;">+44 (0) 203 695 5442</a> or email us at <a href="mailto:hello@fashion-formula.com" style="display: inline-block;">hello@fashion-formula.com</a></p>
                                    <form class="contact-form-input" action="{{ Request::url() }}" method="POST">
                                        {{ csrf_field() }}
                                        <input class="contact-form-input__field" type="text" name="name" value="{{ old('name') }}" placeholder="Full Name" />
                                        <input class="contact-form-input__field" type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" />
                                        <input class="contact-form-input__field" type="tel" name="phone" value="{{ old('phone') }}" placeholder="Phone Number" />
                                        <input class="contact-form-input__field" type="text" name="subject" value="{{ old('subject') }}" placeholder="Subject" />
                                        <textarea class="contact-form-input__textarea" name="message" placeholder="Message" cols="30" rows="5">{{ old('message') }}</textarea>
                                        <button class="contact-form-input__btn btn-primary btn-primary--minor" type="submit"><span>Send</span></button>
                                    </form>
                                    <h2 class="contact-form__hdr push-down">Office Address</h2>
                                    <address class="contact-form__para address">
                                        Fashion Formula<br />
                                        Drakeglen House<br />
                                        35-36 Disraeli Rd<br />
                                        London<br />
                                        United Kingdom<br />
                                        NW10 7AX
                                    </address>
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
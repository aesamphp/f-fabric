@section('page_title', 'Account Settings')
@section('page_class', 'page-account-settings')


@extends('layouts.master')

@section('content')
@include('includes.mobile-nav')
@include('includes.header')

<main>

    <div class="container container-global">
        <div class="row">

            <div class="col-xs-12 container-dotted-pattern no-pad">
                @include('includes.flash')
                <div class="section-fill">
                    <div class="account-tabs">
                        <ul class="account-tabs nav nav-tabs" role="tablist">
                            <li role="account-settings" class="col-xs-3 no-pad tab-single @if ($tab === null) active @endif">
                                <a href="#account-settings" aria-controls="account-settings" role="tab" data-toggle="tab">Account Settings</a>
                            </li>
                            <li role="addr-details" class="col-xs-3 no-pad tab-single @if ($tab === 'address') active @endif">
                                <a href="#addr-details" aria-controls="addr-details" role="tab" data-toggle="tab">Address Details</a>
                            </li>
                            <li role="payment-details" class="col-xs-3 no-pad tab-single @if ($tab === 'payment') active @endif">
                                <a href="#payment-details" aria-controls="payment-details" role="tab" data-toggle="tab">Payment Details</a>
                            </li>
                            <li role="email-settings" class="col-xs-3 no-pad tab-single @if ($tab === 'email') active @endif">
                                <a href="#email-settings" aria-controls="email-settings" role="tab" data-toggle="tab">Email Settings</a>
                            </li>
                            <li role="deactivate-acc" class="col-xs-3 no-pad tab-single">
                                <a href="#deactivate-acc" aria-controls="deactivate-acc" role="tab" data-toggle="tab">Deactivate Account</a>
                            </li>
                        </ul>						
                    </div>
                    <div class="account-tabs-content tab-content clearfix">
                        <div role="tabpanel" class="account-tab account-tabs-first tab-pane @if ($tab === null) active @endif" id="account-settings">
                            @include('user.account.settings')
                        </div>
                        <div role="tabpanel" class="account-tab account-tabs-second tab-pane @if ($tab === 'address') active @endif" id="addr-details">
                            @include('user.account.address')
                        </div>
                        <div role="tabpanel" class="account-tab account-tabs-second tab-pane @if ($tab === 'payment') active @endif" id="payment-details">
                            @include('user.account.payment')
                        </div>
                        <div role="tabpanel" class="account-tab account-tabs-third tab-pane @if ($tab === 'email') active @endif" id="email-settings">
                            @include('user.account.email')
                        </div>
                        <div role="tabpanel" class="account-tab account-tabs-fourth tab-pane" id="deactivate-acc">			
                            @include('user.account.deactivate')
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</main>


@include('includes.footer')
@stop

@section('end_body')
<script type="text/javascript">
    App.config.routes.bucksnetPaymentDetailsURL = "{{ route('view.user.bucksnet.payment') }}";
    $(function() {
        $('.btn-edit').click(function() {
            $('.address-list').hide();

            var url = App.config.routes.baseURL + "/user/account/address/" + $(this).data('id');

            $.get(url, function(response) {
                $('.edit-address').html(response).fadeIn();
                App.functions.autoSelectValue($('select.auto-select'));
                App.functions.handleUSStatesField();
                $(document).trigger('initializeFancyDropdown');
                $('select.select-country').trigger('change');

            }).fail(function(error) {
                alert(error.responseText);
            });
        });

        $('.account-tabs-content').on('click', '.cancel', function() {
            $('.edit-address').hide();
            $('.address-list').fadeIn();
        });

        $('.account-tabs-content').on('submit', '#edit-address-form', function() {
            var $form = $(this);
            var url = App.config.routes.baseURL + "/user/account/address/" + $form.data('id');
            var formData = $form.serializeArray();
            var $valid = $('input[name="valid"]');

            if($valid.val() == 'false')
            {
                $.post(url, formData, function(response) {
                    $valid.val(true);
                    $form.submit();
                }).fail(function(error) {
                    if (error.status === 400) {
                        var errors = error.responseJSON;
                        for (var index in formData) {
                            var $field = $form.find('#edit_' + formData[index].name);
                            if (errors[formData[index].name] === undefined) {
                                $field.parent().removeClass('error');
                            }
                            else {
                                $field.parent().addClass('error');
                            }
                        }
                    }
                    else {
                        alert(error.responseText);
                    }
                });

                return false;
            }
        });
        
        $.fn.toggleVATNumberField = function() {
            var $this = $('input[name=vat_registered]:checked'),
                $vatNumberField = $('.vat-number-field');
            if (parseInt($this.val()) === 1) {
                $vatNumberField.removeClass('hidden');
            } else {
                $vatNumberField.addClass('hidden').find('input#vat_number').val('');
            }
        };
        
        $.fn.toggleBucksnetFields = function() {
            var $this = $('select.tax-country'),
                $bucksnetFields = $('.bucksnet-form-fields'),
                $paypalField = $('.paypal-email-field'),
                $form = $('form#update-user-payment');
            if ($this.val() === "GB") {
                if ($bucksnetFields.length === 0) {
                    $.get(App.config.routes.bucksnetPaymentDetailsURL, function(response) {
                        $form.find('.row:last').before(response);
                    });
                }
                $paypalField.addClass('hidden');
                $bucksnetFields.removeClass('hidden');
            } else {
                $bucksnetFields.addClass('hidden');
                $paypalField.removeClass('hidden');
            }
        };
        
        $.fn.toggleVATNumberField();
        $.fn.toggleBucksnetFields();
        $('input[name=vat_registered]').bind('change', $.fn.toggleVATNumberField);
        $('select.tax-country').bind('change', $.fn.toggleBucksnetFields);
    });
</script>
@stop
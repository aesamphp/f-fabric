<div class="account-tabs-third__col-1 col-md-6 col-xs-12 no-pad clearfix">
    <h2 class="account-tab__hdr hdr-section">Payment Details</h2>
    <p class="account-tab__para">We need your payment details to pay you the money you earn.</p>
    @if ($user->hasPaymentDetails())
    <form id="update-user-payment" method="POST" action="{{ route('update.user.payment') }}" autocomplete="off">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <div class="row">
            <div class="col-xs-12">
                <label class="account-tab-input__label" for="country">What country do you/ your company reside and pay taxes in?*</label>
                <div class="col-xs-12 col-sm-6 no-pad">
                    <select id="country" name="country" class="auto-select tax-country" data-value="{{ getFormFieldValue($user->paymentDetail, 'country') }}">
                        <option value="">Please Select</option>
                        {!! generateDropdownFromArray($countries) !!}
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <label class="account-tab-input__label">Are you VAT registered?*</label>
                <div class="radio-container radio-inline">
                    <input id="vat_registered_yes" type="radio" name="vat_registered" value="1"@if (getFormFieldValue($user->paymentDetail, 'vat_registered') == 1) checked @endif />
                    <span class="checkbox-overlay"></span>
                    <label for="vat_registered_yes" class="checkbox-text hdr-input-type">Yes</label>
                </div>
                <div class="radio-container radio-inline">
                    <input id="vat_registered_no" type="radio" name="vat_registered" value="0"@if (getFormFieldValue($user->paymentDetail, 'vat_registered') != 1) checked @endif />
                    <span class="checkbox-overlay"></span>
                    <label for="vat_registered_no" class="checkbox-text hdr-input-type">No</label>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 vat-number-field hidden">
                <label class="account-tab-input__label" for="vat_number">VAT Number*</label>
                <input class="account-tab-input__field field-secondary" id="vat_number" type="text" name="vat_number" value="{{ getFormFieldValue($user->paymentDetail, 'vat_number') }}" placeholder="Enter VAT Number" />
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 paypal-email-field">
                <label class="account-tab-input__label" for="paypal_email">Paypal Email Address*</label>
                <input class="account-tab-input__field field-secondary" id="paypal_email" type="email" name="paypal_email" value="{{ getFormFieldValue($user->paymentDetail, 'paypal_email') }}" placeholder="Enter Paypal Email Address" />
            </div>
        </div>
        <div class="row">
            <div class="col-xs-offset-6 col-xs-6">
                <button class="account-tab-input__btn account-tab-input__btn--add-pad btn-primary btn-primary--minor" type="submit"><span>Save Changes</span></button>
            </div>	
        </div>
        <input type="hidden" name="tab" value="payment" />
    </form>
    @else
    <form method="POST" action="{{ route('store.user.payment') }}" autocomplete="off">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-xs-12">
                <label class="account-tab-input__label" for="country">What country do you/ your company reside and pay taxes in?*</label>
                <div class="col-xs-12 col-sm-6 no-pad">
                    <select id="country" name="country" class="auto-select tax-country" data-value="{{ old('country') }}">
                        <option value="">Please Select</option>
                        {!! generateDropdownFromArray($countries) !!}
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <label class="account-tab-input__label">Are you VAT registered?*</label>
                <div class="radio-container radio-inline">
                    <input id="vat_registered_yes" type="radio" name="vat_registered" value="1"@if (old('vat_registered') == 1) checked @endif />
                    <span class="checkbox-overlay"></span>
                    <label for="vat_registered_yes" class="checkbox-text hdr-input-type">Yes</label>
                </div>
                <div class="radio-container radio-inline">
                    <input id="vat_registered_no" type="radio" name="vat_registered" value="0"@if (old('vat_registered') != 1) checked @endif />
                    <span class="checkbox-overlay"></span>
                    <label for="vat_registered_no" class="checkbox-text hdr-input-type">No</label>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 vat-number-field hidden">
                <label class="account-tab-input__label" for="vat_number">VAT Number*</label>
                <input class="account-tab-input__field field-secondary" id="vat_number" type="text" name="vat_number" value="{{ old('vat_number') }}" placeholder="Enter VAT Number" />
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 paypal-email-field">
                <label class="account-tab-input__label" for="paypal_email">Paypal Email Address*</label>
                <input class="account-tab-input__field field-secondary" id="paypal_email" type="email" name="paypal_email" value="{{ old('paypal_email') }}" placeholder="Enter Paypal Email Address" />
            </div>
        </div>
        <div class="row bucksnet-form-fields hidden">
            <div class="col-xs-12 col-sm-6">
                <label class="account-tab-input__label" for="bank_name">Bank Name*</label>
                <input class="account-tab-input__field field-secondary" id="bank_name" type="text" name="bank_name" value="{{ old('bank_name') }}" placeholder="Enter bank name" />
            </div>
            <div class="col-xs-12 col-sm-6">
                <label class="account-tab-input__label" for="account_holder_name">Account Holder Name*</label>
                <input class="account-tab-input__field field-secondary" id="account_holder_name" type="text" name="account_holder_name" value="{{ old('account_holder_name') }}" placeholder="Enter account holder name" />
            </div>
        </div>
        <div class="row bucksnet-form-fields hidden">
            <div class="col-xs-12 col-sm-6">
                <label class="account-tab-input__label" for="account_number">Account Number*</label>
                <input class="account-tab-input__field field-secondary" id="account_number" type="tel" name="account_number" value="{{ old('account_number') }}" placeholder="Enter account number" />
            </div>
            <div class="col-xs-12 col-sm-6">
                <label class="account-tab-input__label" for="sort_code">Sort Code*</label>
                <input class="account-tab-input__field field-secondary" id="sort_code" type="tel" name="sort_code" value="{{ old('sort_code') }}" placeholder="Enter sort code" />
            </div>
        </div>
        <div class="row">
            <div class="col-xs-offset-6 col-xs-6">
                <button class="account-tab-input__btn account-tab-input__btn--add-pad btn-primary btn-primary--minor" type="submit"><span>Save Changes</span></button>
            </div>	
        </div>
        <input type="hidden" name="tab" value="payment" />
    </form>
    @endif
</div>
<div class="account-tabs-third__col-2 col-md-6 col-xs-12 no-pad clearfix">
    <h2 class="account-tab__hdr hdr-section">Disclaimer</h2>
    <p class="account-tab__para">
        The information contained in this website is for general information purposes only. The information is provided by Fashion Formula Ltd and while we endeavour to keep the information up to date and correct, we make no representations or warranties of any kind, express or implied, about the completeness, accuracy, reliability, suitability or availability with respect to the website or the information, products, services, or related graphics contained on the website for any purpose. Any reliance you place on such information is therefore strictly at your own risk.
        <br /><br />
        In no event will we be liable for any loss or damage including without limitation, indirect or consequential loss or damage, or any loss or damage whatsoever arising from loss of data or profits arising out of, or in connection with, the use of this website.
        <br /><br />
        Through this website you are able to link to other websites which are not under the control of Fashion Formula Ltd. We have no control over the nature, content and availability of those sites. The inclusion of any links does not necessarily imply a recommendation or endorse the views expressed within them.
        <br /><br />
        Every effort is made to keep the website up and running smoothly. However, Fashion Formula Ltd takes no responsibility for, and will not be liable for, the website being temporarily unavailable due to technical issues beyond our control.
    </p>
</div>
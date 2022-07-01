<form method="POST" id="edit-address-form" action="{{ route('update.user.address', ['id' => $address->id]) }}" autocomplete="off" data-id="{{ $address->id }}">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
    <h2 class="account-tab__hdr hdr-section">Edit Address</h2>

    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <label class="account-tab-input__label" for="edit_title">Address Name*</label>
            <input class="account-tab-input__field field-secondary" id="edit_title" type="text" name="title" value="{{ getFormFieldValue($address, 'title') }}" placeholder="Please enter a reference name eg..." />
        </div>
        <div class="col-xs-12 col-sm-6">
            <label class="account-tab-input__label" for="edit_address_line1">Address Line 1*</label>
            <input class="account-tab-input__field field-secondary" id="edit_address_line1" type="text" name="address_line1" value="{{ getFormFieldValue($address, 'address_line1') }}" placeholder="Please enter Address Line 1" />
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <label class="account-tab-input__label" for="edit_address_line2">Address Line 2</label>
            <input class="account-tab-input__field field-secondary" id="edit_address_line2" type="text" name="address_line2" value="{{ getFormFieldValue($address, 'address_line2') }}" placeholder="Please enter Address Line 2" />
        </div>
        <div class="col-xs-12 col-sm-6">
            <label class="account-tab-input__label" for="edit_city">Town/City*</label>
            <input class="account-tab-input__field field-secondary" id="edit_city" type="text" name="city" value="{{ getFormFieldValue($address, 'city') }}" placeholder="Please enter a Town/City" />
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <label class="account-tab-input__label" for="edit_postcode">Zip/Postal Code*</label>
            <input class="account-tab-input__field field-secondary" id="edit_postcode" type="text" name="postcode" value="{{ getFormFieldValue($address, 'postcode') }}" placeholder="Please enter your Postcode" />
        </div>
        <div class="col-xs-12 col-sm-6">
            <label class="account-tab-input__label" for="edit_country">Country*</label>
            <select id="edit_country" name="country" class="auto-select select-country" data-value="{{ getFormFieldValue($address, 'country') }}">
                <option value="">Please Select</option>
                {!! generateDropdownFromArray($countries) !!}
            </select>
        </div>
        <div class="col-xs-12 col-sm-6 input-field">
            <label class="account-tab-input__label" for="state">State*</label>
            <select id="state" name="state" class="auto-select select-state" data-value="{{ getFormFieldValue($address, 'state') }}">
                <option value="">Please Select</option>
                {!! generateDropdownOptions($states->toArray(), 'code', 'title') !!}
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <span class="cancel account-tab-input__btn--add-pad" style="display: inline-block; cursor: pointer;">Cancel</span>
        </div>

        <div class="col-xs-6">
            <input type="hidden" name="valid" value="false" />
            <button class="account-tab-input__btn account-tab-input__btn--add-pad btn-primary btn-primary--minor" type="submit"><span>Save Changes</span></button>
        </div>  
    </div>                                                                                                          
</form>
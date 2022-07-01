<div class="row bucksnet-form-fields">
    <div class="col-xs-12 col-sm-6">
        <label class="account-tab-input__label" for="bank_name">Bank Name*</label>
        <input class="account-tab-input__field field-secondary" id="bank_name" type="text" name="bank_name" value="{{ $bucksnet->bank_name }}" placeholder="Enter bank name" />
    </div>
    <div class="col-xs-12 col-sm-6">
        <label class="account-tab-input__label" for="account_holder_name">Account Holder Name*</label>
        <input class="account-tab-input__field field-secondary" id="account_holder_name" type="text" name="account_holder_name" value="{{ $bucksnet->account_holder_name }}" placeholder="Enter account holder name" />
    </div>
</div>
<div class="row bucksnet-form-fields">
    <div class="col-xs-12 col-sm-6">
        <label class="account-tab-input__label" for="account_number">Account Number*</label>
        <input class="account-tab-input__field field-secondary" id="account_number" type="tel" name="account_number" value="{{ $bucksnet->account_number }}" placeholder="Enter account number" />
    </div>
    <div class="col-xs-12 col-sm-6">
        <label class="account-tab-input__label" for="sort_code">Sort Code*</label>
        <input class="account-tab-input__field field-secondary" id="sort_code" type="tel" name="sort_code" value="{{ $bucksnet->sort_code }}" placeholder="Enter sort code" />
    </div>
</div>
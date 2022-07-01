<div class="account-tabs-second__col-1 col-md-6 col-xs-12 no-pad clearfix">
    <div class="address-list">
        <h2 class="account-tab__hdr hdr-section">Address List</h2>

        <div class="account-tab-input form-group">
            <div class="row">
                @if (count($user->addresses) > 0)
                    @foreach ($user->addresses as $address)
                    <div class="col-xs-12 col-sm-6">
                        {!! formatAddress($address, $address->getAddressAttributes()) !!}
                        <button class="btn-edit btn-primary btn-primary--minor" type="submit" data-id="{{ $address->id }}"><span>Edit</span></button>
                        <form class="delete-form" method="POST" action="{{ route('delete.user.address', ['id' => $address->id]) }}">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button class="btn-delete btn-primary btn-primary--minor btn-primary--warning" type="submit"><span>Delete</span></button>
                        </form>
                    </div>
                    @endforeach
                @else
                <div class="col-xs-12">
                    <p>You don't have any address saved in your address list.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="edit-address" style="display: none;"></div>
</div>

<div class="account-tabs-second__col-2 col-md-6 col-xs-12 no-pad clearfix">
    <form method="POST" action="{{ route('store.user.address') }}" autocomplete="off">
        {{ csrf_field() }}
        <h2 class="account-tab__hdr hdr-section">Add Another Address</h2>
 
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <label class="account-tab-input__label" for="title">Address Name*</label>
                <input class="account-tab-input__field field-secondary" id="title" type="text" name="title" value="{{ old('title') }}" placeholder="Please enter a reference name eg..." />
            </div>
            <div class="col-xs-12 col-sm-6">
                <label class="account-tab-input__label" for="address_line1">Address Line 1*</label>
                <input class="account-tab-input__field field-secondary" id="address_line1" type="text" name="address_line1" value="{{ old('address_line1') }}" placeholder="Please enter Address Line 1" />
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <label class="account-tab-input__label" for="address_line2">Address Line 2</label>
                <input class="account-tab-input__field field-secondary" id="address_line2" type="text" name="address_line2" value="{{ old('address_line2') }}" placeholder="Please enter Address Line 2" />
            </div>
            <div class="col-xs-12 col-sm-6">
                <label class="account-tab-input__label" for="city">Town/City*</label>
                <input class="account-tab-input__field field-secondary" id="city" type="text" name="city" value="{{ old('city') }}" placeholder="Please enter a Town/City" />
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <label class="account-tab-input__label" for="postcode">Zip/Postal Code*</label>
                <input class="account-tab-input__field field-secondary" id="postcode" type="text" name="postcode" value="{{ old('postcode') }}" placeholder="Please enter your Postcode" />
            </div>
            <div class="col-xs-12 col-sm-6">
                <label class="account-tab-input__label" for="country">Country*</label>
                <select id="country" name="country" class="auto-select select-country" data-value="{{ old('country') }}">
                    <option value="">Please Select</option>
                    {!! generateDropdownFromArray($countries) !!}
                </select>
            </div>
            <div class="col-xs-12 col-sm-6 input-field">
                <label class="account-tab-input__label" for="state">State*</label>
                <select id="state" name="state" class="auto-select select-state" data-value="{{ old('state') }}">
                    <option value="">Please Select</option>
                    {!! generateDropdownOptions($states->toArray(), 'code', 'title') !!}
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-offset-6 col-xs-6">
                <button class="account-tab-input__btn account-tab-input__btn--add-pad btn-primary btn-primary--minor" type="submit"><span>Add Address</span></button>
            </div>	
        </div>
        <input type="hidden" name="tab" value="address" />
    </form>
</div>
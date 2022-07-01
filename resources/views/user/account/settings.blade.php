<div class="account-tabs-first__col-1 col-md-6 col-xs-12 no-pad clearfix">
    <form method="POST" action="{{ route('update.user.account') }}">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <h2 class="account-tab__hdr hdr-section">Account Settings</h2>

        <div class="row">
            <div class="col-xs-12">
                <label class="account-tab-input__label" for="email">Update Email Address</label>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <input class="account-tab-input__field field-secondary" id="email" type="email" name="email" value="{{ getFormFieldValue($user, 'email') }}" placeholder="Please enter your email address" />
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <label class="account-tab-input__label" for="first_name">First Name</label>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <input class="account-tab-input__field field-secondary" id="first_name" type="text" name="first_name" value="{{ getFormFieldValue($user, 'first_name') }}" placeholder="Please enter your first name" />
            </div>	
        </div>
        <div class="row">
            <div class="col-xs-12">
                <label class="account-tab-input__label" for="last_name">Last Name</label>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <input class="account-tab-input__field field-secondary" id="last_name" type="text" name="last_name" value="{{ getFormFieldValue($user, 'last_name') }}" placeholder="Please enter your last name" />
            </div>	
        </div>		
        <div class="row">
            <div class="col-xs-12">
                <label class="account-tab-input__label" for="username">Username</label>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <input class="account-tab-input__field field-secondary" id="username" type="text" name="username" value="{{ getFormFieldValue($user, 'username') }}" placeholder="Please re-enter your username" />
            </div>
            <div class="col-xs-12 col-sm-6">
                <button class="account-tab-input__btn btn-primary btn-primary--minor" type="submit"><span>Update Details</span></button>
            </div>	
        </div>													

        <input type="hidden" name="tab" value="settings" />
    </form>
</div>
<div class="account-tabs-first__col-2 col-md-6 col-xs-12 no-pad clearfix">
    <form method="POST" action="{{ route('update.user.password') }}" autocomplete="off">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <div class="row">
            <div class="col-xs-12">
                <label class="account-tab-input__label" for="password">Reset Password</label>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <input class="account-tab-input__field field-secondary" id="password" type="password" name="password" placeholder="Please enter a password" />
            </div>	
        </div>		
        <div class="row">
            <div class="col-xs-12">
                <label class="account-tab-input__label" for="password_confirmation">Confirm Password</label>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <input class="account-tab-input__field field-secondary" id="password_confirmation" type="password" name="password_confirmation" placeholder="Please re-enter a pasword" />
            </div>
            <div class="col-xs-12 col-sm-6">
                <button class="account-tab-input__btn btn-primary btn-primary--minor" type="submit"><span>Reset Password</span></button>
            </div>	
        </div>													

        <input type="hidden" name="tab" value="settings" />
    </form>
</div>
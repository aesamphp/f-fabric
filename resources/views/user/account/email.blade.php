<form method="POST" action="{{ route('update.user.email') }}">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
    <div class="account-tabs-third__col-1 col-md-6 col-xs-12 no-pad clearfix">
        <h2 class="account-tab__hdr hdr-section">Email Settings</h2>
        <p class="account-tab__para">We'd like to keep in touch with you regarding any news or updates. Fashion Formula respects your privacy and will not spam you.</p>
        <p class="account-tab__title">Email me when I receive</p>
        <div class="checkbox-container">
            <input type="checkbox" id="sales_checkbox" class="checkbox-boolean" data-input="sales_email" name="sales_checkbox" value="1"@if ($user->sales_email) checked @endif />
            <span class="checkbox-overlay"></span>
            <label for="sales_checkbox" class="checkbox-text">Sales</label>
        </div>
        <div class="checkbox-container">
            <input type="checkbox" id="favourites_checkbox" class="checkbox-boolean" data-input="favourites_email" name="favourites_checkbox" value="1"@if ($user->favourites_email) checked @endif />
            <span class="checkbox-overlay"></span>
            <label for="favourites_checkbox" class="checkbox-text">Favourites</label>
        </div>
        <div class="checkbox-container">
            <input type="checkbox" id="newsletter_checkbox" class="checkbox-boolean" data-input="newsletter_email" name="newsletter_checkbox" value="1"@if ($user->newsletter_email) checked @endif />
            <span class="checkbox-overlay"></span>
            <label for="newsletter_checkbox" class="checkbox-text">Newsletter updates</label>
        </div>
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
        <button class="account-tab__btn btn-primary btn-primary--minor" type="submit"><span>Save Changes</span></button>
    </div>
    <input id="sales_email" type="hidden" name="sales_email" value="{{ $user->sales_email }}" />
    <input id="favourites_email" type="hidden" name="favourites_email" value="{{ $user->favourites_email }}" />
    <input id="newsletter_email" type="hidden" name="newsletter_email" value="{{ $user->newsletter_email }}" />
    <input type="hidden" name="tab" value="email" />
</form>
<h2 class="account-tab__hdr hdr-section">Deactivate Account</h2>
<p class="account-tab__subhdr">Are you sure would like to deactivate your Fashion Formula account?</p>
<form class="delete-form" action="{{ route('delete.user.account') }}" method="POST" data-message="Are you sure you want to deactivate it?">
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
    <button type="submit" class="account-tab__btn btn-primary btn-primary--warning"><span>Delete Account</span></button>
</form>
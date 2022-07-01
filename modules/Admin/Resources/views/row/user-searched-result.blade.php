@if(count($user) > 0)
    <div class="search-row" data-user-id="{{ $user->id }}">
        <input type="hidden" value="{{ $user->id }}" name="user-id-{{ $user->id }}" /> <span>{{ $user->getFullName() }}</span>
        <div class="btn teal waves-effect waves-light right remove-user">Remove</div>
    </div>
@else
    <div class="alert alert-warning">There were no results for your search.</div>
@endif
@if(count($users) > 0)

    @foreach($users as $user)
        <div class="search-row" data-user-id="{{ $user->id }}">
            <input type="hidden" value="{{ $user->id }}" name="user-id-{{ $user->id }}" /> <span>{{ $user->getFullName() }}</span>
            <div class="btn teal waves-effect waves-light right select-user">Select</div>
        </div>
    @endforeach

@else
    <div class="alert alert-warning">There were no results for your search.</div>
@endif
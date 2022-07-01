@if(count($designs) > 0)

    @foreach($designs as $design)
        <div class="search-row" data-design-id="{{ $design->id }}">
            <input type="hidden" name="design-id-{{ $design->id }}" value="{{ $design->id }}" /><span>{{ $design->title }}</span>
            <div class="btn teal waves-effect waves-light right select-design">Select</div>
            <div class="btn teal waves-effect waves-light right remove-design hide">Remove</div>
        </div>
    @endforeach

@else
    <div class="alert alert-warning">There were no results for your search.</div>
@endif
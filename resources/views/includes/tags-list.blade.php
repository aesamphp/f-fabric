@if (count($labelCollection) > 0)
    @foreach ($labelCollection as $character => $labels)
    <ul data-text="{{ $character }}">
        @foreach ($labels as $label)
            @if ($listType === 'link')
            <li><a class="tag-filter" href="#" data-url="{{ route('search.tag.designs', ['tag' => $label]) }}">{{ $label }}</a></li>
            @elseif ($listType === 'checkbox')
            <div class="aside-checklist__check checkbox-container">
                <input type="checkbox" name="labels[]" value="{{ $label }}"@if (in_array($label, $filterLabels)) checked @endif />
                <span class="checkbox-overlay"></span>
                <span class="checkbox-text">{{ $label }}</span>
            </div>
            @endif
        @endforeach
    </ul>
    @endforeach
@else
<p>No label found</p>
@endif
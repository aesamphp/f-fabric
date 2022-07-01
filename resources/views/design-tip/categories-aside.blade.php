<ul class="list">
    @foreach ($categories as $cat)
    <li class="item @if (!empty($category) && $cat->id === $category->id) active @endif">
        @if (!empty($category) && $cat->id === $category->id)
        {{ $cat->title }}
        @else
        <a class="ajax" data-container="answers" data-page-title="{{ $cat->title . ' | Design Tips' }}" href="{{ route('view.design.tips.category', ['category' => $cat->identifier]) }}">{{ $cat->title }}</a>
        @endif
    </li>
    @endforeach
</ul>
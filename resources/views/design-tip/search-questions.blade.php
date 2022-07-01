@foreach ($searchCategories as $category)
<h2 class="category__hdr">{{ $category->title }}</h2>
    @foreach ($category->designTips as $designTip)
    <div class="answers-single">
        <a class="ajax" data-container="answers" data-page-title="{{ $designTip->title . ' | Design Tips' }}" href="{{ route('view.design.tip', ['category' => $category->identifier, 'identifier' => $designTip->identifier]) }}">
            <h2 class="answers-single__hdr">{{ $designTip->title }}</h2>
        </a>
    </div>
    @endforeach
@endforeach
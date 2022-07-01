<section class="fashion-formula-widget {{ $display == "large" ? "large" : "small" }}">
    <a href="{{ route("view.designer.store", [$user->username]) }}">
        <img class="header-image" src="{{ $display == "large" ? asset('images/promotion/LogoLarge.jpg') : asset('images/promotion/LogoSmall.jpg') }}">
        <p>
            {{ $user->username }}'s {{ $design == "my_shop" ? "Shop" : "Favourites"}}
        </p>
    </a>
    <div class="images" style="width: {{ $display == "large" ? $layoutColumns * 270 : $layoutColumns * 170 }}px;">
        @foreach ($images as $image)
            <a href="{{ route('view.shop.design', ['designIdentifier' => $image->identifier]) }}">
                <img src="{{ asset($image->getWatermarkImagePath()) }}">
            </a>
        @endforeach
    </div>
</section>

<button class="btn-tertiary--gray pull-right"><span>Copy to clipboard</span></button>
<div class="link-content">
    <div disabled="disabled" class="code-example">
    </div>
</div>

<link type="text/css" rel="stylesheet" href="{{ asset('css/widget.css') }}" />

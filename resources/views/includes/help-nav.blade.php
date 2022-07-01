<div class="faqs-head" {{ $route = Route::getCurrentRoute()->getPath() }}>
    <div class="row">
        <div class="col-xs-2 col-md-offset-1">
            <a href="{{route('view.delivery.and.returns')}}"
               class="{{ $route == "delivery-and-returns" ? "faqs-head__item faqs-head__item--active" : "faqs-head__item" }}">Delivery & Returns</a></div>
        <div class="col-xs-2">
            <a href="{{route('view.terms.and.conditions')}}"
               class="{{ $route == "terms-and-conditions" ? "faqs-head__item faqs-head__item--active" : "faqs-head__item" }}">Terms &amp; Conditions</a>
        </div>
        <div class="col-xs-2">
            <a href="{{route('view.faqs')}}"
               class="{{ $route == "faqs" ? "faqs-head__item faqs-head__item--active" : "faqs-head__item" }}">Frequently Asked Questions</a>
        </div>
        <div class="col-xs-2">
            <a href="{{route('view.privacy')}}"
               class="{{ $route == "privacy" ? "faqs-head__item faqs-head__item--active" : "faqs-head__item" }}">Privacy</a>
        </div>
        <div class="col-xs-2">
            <a href="{{route('view.design.tips')}}"
               class="{{ $route == "design-tips" ? "faqs-head__item faqs-head__item--active" : "faqs-head__item" }}">Design Tips</a>
        </div>
    </div>
</div>
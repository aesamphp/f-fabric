@section('page_title', 'Designer Store')
@section('page_class', 'shop-designer-store-page')


@extends('layouts.master')

@section('content')
@include('includes.mobile-nav')
@include('includes.header')

<main>

    <div class="container container-global">
        <div class="row">

            <div class="col-xs-12 container-dotted-pattern">
                <div class="row">

                    <!-- FEATURED DESIGNER -->
                    <div class="col-xs-12 no-pad clearfix">
                        <section class="featured-designer">
                            <div class="featured-designer__img" style="background-image: url('{{ asset($store->getHeaderImagePath()) }}');"></div>
                        </section>
                    </div>

                    <div class="inner-section">
                        <form class="filter-store-designs" method="GET" action="{{ route('view.designer.store', ['username' => $store->username]) }}">
                            <!-- ASIDE -->
                            <div class="col-md-3 col-sm-12 aside-boot clearfix">
                                <div class="col-xs-12 col-md-12 no-pad clearfix">
                                    <aside class="aside-designer section-fill section-fill--aside">

                                        <h3 class="js-toggle-slide aside-designer__hdr hdr-aside hdr-aside--black hdr-aside--minor">Designs by {{ $designer->username }}</h3>

                                        <div class="js-open-content open-content">
                                            <div class="aside-designer__img" style="background-image: url('{{ asset($store->getImagePath()) }}');"></div>
                                            <h3 class="aside-designer__subhdr hdr-aside hdr-aside--minor">
                                                {{ $store->getFullName() }}
                                                <span>{{ $store->getLocation() }}</span>
                                            </h3>
                                            <div class="aside-designer-social">
                                                <a href="{{ getShareURL(route('view.designer.store', ['username' => $store->username]), 'facebook') }}" target="_blank" class="aside-designer-social__btn btn-social fb"></a>
                                                <a href="{{ getShareURL(route('view.designer.store', ['username' => $store->username]), 'twitter') }}" target="_blank" class="aside-designer-social__btn btn-social tw"></a>
                                                <a href="{{ getShareURL(route('view.designer.store', ['username' => $store->username]), 'pinterest') }}" target="_blank" class="aside-designer-social__btn btn-social pn"></a>
                                            </div>
                                            <p class="aside-designer__para">{{ $store->about_me }}</p>
                                            @if ($store->store_link)
                                            <a href="{{ $store->store_link }}" class="aside-designer__link link-addr" target="_blank">{{ extractDomainFromURL($store->store_link) }}</a>
                                            @endif
                                        </div> 

                                    </aside>
                                </div>
                                
                                <div class="col-xs-12 col-md-12 no-pad clearfix">
                                    <aside class="aside-checklist section-fill section-fill--aside">

                                        <h3 class="js-toggle-slide aside-checklist__hdr hdr-aside hdr-aside--black hdr-aside--minor">Explore</h3>

                                        <div class="js-open-content open-content">
                                            <div class="aside-checklist__check checkbox-container">
                                                <input id="category-all" type="checkbox" name="category[]" value="all"@if (in_array('all', $categoryFilters)) checked @endif />
                                                <span class="checkbox-overlay"></span>
                                                <label for="category-all" class="checkbox-text">All ({{ $designer->getAllDesignsCount(false) }})</label>
                                            </div>
                                            @foreach ($categories as $category)
                                            <div class="aside-checklist__check checkbox-container">
                                                <input id="category-{{ $category->identifier }}" type="checkbox" name="category[]" value="{{ $category->id }}"@if (in_array($category->id, $categoryFilters)) checked @endif />
                                                <span class="checkbox-overlay"></span>
                                                <label for="category-{{ $category->identifier }}" class="checkbox-text">{{ $category->title }} ({{ $designer->getCategoryDesignsCount($category->id) }})</label>
                                            </div>
                                            @endforeach
                                            <div class="aside-checklist__check checkbox-container">
                                                <input id="category-not-for-sale" type="checkbox" name="category[]" value="not-for-sale"@if (in_array('not-for-sale', $categoryFilters)) checked @endif />
                                                <span class="checkbox-overlay"></span>
                                                <label for="category-not-for-sale" class="checkbox-text">Not For Sale ({{ $designer->getNotForSaleDesignsCount() }})</label>
                                            </div>
                                        </div> 

                                    </aside>
                                </div>

                                <div class="col-xs-12 no-pad clearfix">
                                    <aside class="aside-labels section-fill section-fill--aside">
                                        <div class="aside-labels-input">
                                            <div class="input-grouped">
                                                <input id="search-tags" type="text" placeholder="Search Tags" class="aside-labels-input__search" data-url="{{ route('search.tags') }}" data-list-type="checkbox" />
                                                <button type="button">&nbsp;</button>
                                            </div>
                                        </div>
                                        <div class="aside-labels-alphabet less-pad-sm">
                                            <h3 class="js-toggle-slide aside-labels-alphabet__hdr">Popular Labels</h3>
                                            <div class="js-open-content aside-labels-alphabet-list tags-list">
                                                @include('includes.tags-list', ['listType' => 'checkbox'])
                                            </div>
                                        </div>
                                    </aside>
                                </div>                            
                            </div>

                            <!-- MAIN SECTION -->
                            <div class="col-md-9 col-sm-12 no-pad shop-scroll-section">

                                <!-- NAVBAR SORT -->
                                <div class="section-fill pad-adjust minus-mar">
                                    <section class="result-search clearfix">
                                        <p id="shop-results-count" class="result-search__para"></p>
                                    </section>
                                    <section class="navbar-sort clearfix">
                                        <div class="js-grid-container navbar-sort-grid">
                                            <img src="{{ asset('images/6x6.png') }}" class="js-grid-thumb navbar-sort-grid__img" />
                                            <img src="{{ asset('images/4x4.png') }}" class="js-grid-tile navbar-sort-grid__img" />
                                        </div>

                                        <div class="navbar-sort-filter">
                                            <div class="single-filter container-width-1">
                                                <label class="single-filter__label" for="arrange">Arrange By:</label>
                                                <div class="js-switch single-filter-switch">
                                                    <button type="button" class="single-filter-switch__btn @if ($arrange == 'ASC') active @endif" value="ASC">A-Z</button>
                                                    <button type="button" class="single-filter-switch__btn @if ($arrange == 'DESC') active @endif" value="DESC">Z-A</button>
                                                </div>
                                            </div>                                        
                                            <div class="single-filter container-width-3">
                                                <label class="single-filter__label" for="filter">Show:</label>
                                                <select class="single-filter__select slim-md auto-select" name="filter" id="filter" data-value="{{ $filter }}">
                                                    {!! generateFilterDropdown() !!}
                                                </select>
                                            </div>
                                        </div>
                                    </section>
                                </div>

                                <!-- PRODUCTS GRID -->
                                <div class="section-fill minus-mar add-pad">
                                    <section class="products-grid shop-fabrics form-ajax-response ajax-pagination-response ajax-container">
                                        @include('store.designer-store-form-content')
                                    </section>
                                </div>
                            </div>
                            <input type="hidden" name="arrange" value="{{ $arrange }}" />
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>

</main>

@include('includes.footer')
@stop

@section('end_body')
<script type="text/javascript">
    $(function() {
        var submitForm =  function() {
            var $this = $(this);
            if ($this.val() === "all") {
                $('form.filter-store-designs input[name="category[]"]').not($this).prop('checked', false);
            } else if ($this.val() === "not-for-sale") {
                $('form.filter-store-designs input[name="category[]"]').not($this).prop('checked', false);
            } else {
                $('form.filter-store-designs input[name="category[]"]:first, form.filter-store-designs input[name="category[]"]:last').prop('checked', false);
            }
            $('form.filter-store-designs').submit();
        };
        $('form.filter-store-designs').on('click', 'input[type="checkbox"]', submitForm);
        $('form.filter-store-designs select').bind('change', submitForm);
        $('form.filter-store-designs input[name="arrange"]').bind('click', submitForm);
        $('button.single-filter-switch__btn').click(function() {
            $('form.filter-store-designs input[name="arrange"]').val($(this).val()).trigger('click');
        });
        $('form.filter-store-designs').submit(function(event) {
            event.preventDefault();
            var $form = $(this),
                $container = $form.find('.form-ajax-response'),
                historyURL = $form.attr('action') + '?' + $form.serialize();
            $.get($form.attr('action'), $form.serialize(), function(response) {
                $container.html(response);
                App.functions.addToBrowserHistory(historyURL, "@yield('page_title')");
                App.functions.autoSelectValue($('select.auto-select'));
                App.functions.scrollToElement($('.shop-scroll-section'));
                $(document).trigger('initMagnificPopup');
            }).fail(function(error) {
                alert(error.responseText);
            });
        });
    });

    App.functions.ajaxInResults("{{ $designs->total() }}", "{{ route('view.designer.pagination', ['username' => $store->username]) }}");

</script>
@stop
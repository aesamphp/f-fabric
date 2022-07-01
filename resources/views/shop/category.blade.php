@section('page_title', 'Shop')
@section('page_class', 'shop-category-page')

@extends('layouts.master')

@section('content')
@include('includes.mobile-nav')
@include('includes.header')

<main>

    <div class="container container-global">
        <div class="row">

            <div class="col-xs-12 container-dotted-pattern">
                <div class="row">

                    <!-- FEATURED BANNER -->
                    <div class="row">
                        <div class="col-xs-12">
                            <section class="featured-banner featured-banner--shop-category">
                                <h1 class="featured-banner__hdr">Shop {{ $category->title }}</h1>
                                <p class="featured-banner__para">Choose from thousands of designs available by talented independent designers</p>
                            </section>
                        </div>
                    </div>

                    <form class="filter-category-designs" method="GET" action="{{ Request::url() }}">

                        <div class="col-md-3 col-sm-12 aside-boot clearfix">

                            <div class="clearfix">
                                <div class="col-xs-12 col-md-12 clearfix no-pad hidden">
                                    <aside class="aside-checklist section-fill section-fill--aside">

                                        <h3 class="js-toggle-slide aside-checklist__hdr hdr-aside">Explore</h3>

                                        <div class="js-open-content open-content">
                                            <div class="aside-checklist__check checkbox-container">
                                                <input id="most-popular" type="checkbox" />
                                                <span class="checkbox-overlay"></span>
                                                <label for="most-popular" class="checkbox-text">Most Popular</label>
                                            </div>
                                            <div class="aside-checklist__check checkbox-container">
                                                <input id="" type="checkbox" />
                                                <span class="checkbox-overlay"></span>
                                                <span class="checkbox-text">Top Sellers</span>
                                            </div>
                                        </div>

                                    </aside>
                                </div>

                                <div class="col-xs-12 col-md-12 clearfix no-pad">
                                    <aside class="aside-checklist section-fill section-fill--aside">
                                        <center>
                                            <button type="button" class="btn-primary btn-primary--no-border btn-clear-form-selection"><span>Clear Selection</span></button>
                                        </center>
                                        <h3 class="js-toggle-slide aside-checklist__hdr hdr-aside">Designed For</h3>

                                        <div class="js-open-content open-content">
                                            <div class="aside-store-category">
                                                <div class="aside-checklist__check checkbox-container">
                                                    <input id="category-all" type="radio" name="category" value="all"@if ($categoryFilter == 'all') checked @endif />
                                                    <span class="checkbox-overlay"></span>
                                                    <label for="category-all" class="checkbox-text">All</label>
                                                </div>
                                                @foreach ($categories as $category)
                                                <div class="aside-checklist__check checkbox-container">
                                                    <input id="category-{{ $category->identifier }}" type="radio" name="category" value="{{ $category->id }}"@if ($categoryFilter == $category->id) checked @endif />
                                                    <span class="checkbox-overlay"></span>
                                                    <label for="category-{{ $category->identifier }}" class="checkbox-text">{{ $category->title }}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </aside>
                                </div>
                            </div>

                            <div class="col-xs-12 clearfix no-pad">
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

                            <!-- ONLY APPEARS IN DESKTOP VIEW -->
                            <div class="">
                                <div class="col-xs-12 clearfix no-pad">
                                    <aside class="aside-colours section-fill section-fill--aside">
                                        <h3 class="js-toggle-slide aside-colours__hdr hdr-aside">Colour</h3>
                                        <a href="{{ route('view.shop.colour.atlas') }}" class="aside-colours__para hidden-xs hidden-sm">View colour atlas</a>
                                        <div class="js-open-content js-colours-container aside-colours-atlas">
                                            @foreach ($coloursCollection as $colour)
                                            <input class="hidden" type="checkbox" name="colours[]" value="{{ arrayToString($colour['values'], ',') }}"@if (in_array(arrayToString($colour['values'], ','), $filterColours)) checked @endif />
                                            <div class="js-colours aside-colours-atlas__stripe {{ strtolower($colour['title']) }}">
                                                @if (in_array(arrayToString($colour['values'], ','), $filterColours))
                                                <p>Selected</p>
                                                @endif
                                            </div>
                                            @endforeach
                                        </div>
                                    </aside>
                                </div>
                                <div class="col-xs-12 clearfix no-pad">
                                    <aside class="aside-checklist section-fill section-fill--aside">
                                        <h3 class="js-toggle-slide aside-checklist__hdr hdr-aside">Availability</h3>
                                        <div class="js-open-content open-content">
                                            <div class="aside-checklist__check checkbox-container">
                                                <input type="radio" name="availability" value="sale"@if ($availability === 'sale') checked @endif />
                                                       <span class="checkbox-overlay"></span>
                                                <span class="checkbox-text">Sale</span>
                                            </div>

                                            <div class="aside-checklist__check checkbox-container">
                                                <input type="radio" name="availability" value="not-for-sale"@if ($availability === 'not-for-sale') checked @endif />
                                                       <span class="checkbox-overlay"></span>
                                                <span class="checkbox-text">Not for Sale</span>
                                            </div>

                                            <div class="aside-checklist__check checkbox-container">
                                                <input type="radio" name="availability" value="all"@if ($availability === 'all') checked @endif />
                                                       <span class="checkbox-overlay"></span>
                                                <span class="checkbox-text">All</span>
                                            </div>
                                        </div>
                                    </aside>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-9 col-sm-12 no-pad shop-scroll-section">

                            <div class="section-fill pad-adjust minus-mar">

                                <section class="result-search clearfix">
                                    <p id="shop-results-count" class="result-search__para"></p>
                                    <div class="result-search__input input-grouped">
                                        <input type="text" name="keyword" value="{{ $keyword }}" placeholder="Search fabric, wallpaper and giftwrap..." />
                                        <button type="submit" class="btn-primary btn-primary--no-border"><span>Search</span></button>
                                    </div>
                                </section>

                                <section class="navbar-sort clearfix">
                                    <div class="js-grid-container navbar-sort-grid">
                                        <img src="{{ asset('images/6x6.png') }}" class="js-grid-thumb navbar-sort-grid__img" />
                                        <img src="{{ asset('images/4x4.png') }}" class="js-grid-tile navbar-sort-grid__img" />
                                    </div>

                                    <div class="navbar-sort-filter">
                                        <div class="single-filter">
                                            <label class="single-filter__label" for="filter">Arrange By:</label>
                                            <select class="single-filter__select auto-select" name="filter" id="filter" data-value="{{ $filter }}">
                                                {!! generateFilterDropdown() !!}
                                            </select>
                                        </div>
                                    </div>
                                </section>
                            </div>

                            <div class="section-fill minus-mar add-pad">
                                <section class="products-grid shop-fabrics form-ajax-response ajax-pagination-response ajax-container">
                                    @include('shop.category-form-content')
                                </section>
                            </div>

                        </div>

                    </form>

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
            var $this = $(this),
                $form = $this.parents('form.filter-category-designs');
            $form.submit();
        },
        resetForm = function() {
            var $this = $(this),
                $form = $this.parents('form.filter-category-designs'),
                $colourFilters = $form.find('.js-colours-container .js-colours'),
                $tagsField = $form.find('input#search-tags');
            $colourFilters.removeClass("selected").find('p').remove();
            $form.trigger('reset').submit();
            $tagsField.trigger('keyup');
        };
        $('form.filter-category-designs').on('click', 'input[type="checkbox"]', submitForm);
        $('form.filter-category-designs').on('click', 'input[type="radio"]', submitForm);
        $('form.filter-category-designs').on('change', 'select', submitForm);
        $('form.filter-category-designs').on('click', '.btn-clear-form-selection', resetForm);
        $('form.filter-category-designs').submit(function(event) {
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

    App.functions.ajaxInResults("{{ $designs->total() }}", "{{ route('view.shop.pagination') }}");
</script>
@stop
<header>
  @if (isset($globalNotificationBanner))
    @if ($globalNotificationBanner->link)
      <a href="{{ $globalNotificationBanner->link }}">
        <section class="notification-banner">
          {{ $globalNotificationBanner->text }}
        </section>
      </a>
    @else
      <section class="notification-banner">
        {{ $globalNotificationBanner->text }}
      </section>
    @endif
  @endif
  <section class="header">
    <div class="container container-global">
      <div class="row">

        <div class="col-xs-3 visible-xs visible-sm">
          <a href="#" class="js-burger header-burger"></a>
        </div>

        <div class="col-lg-5 col-md-3 col-xs-6 no-pad-lg">
          <a href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="header__logo"/>
          </a>
        </div>

        <div class="col-xs-3 visible-xs visible-sm">
          <a href="{{ route('view.basket') }}" class="mobile-basket">
            <span id="mobile-basket-count" class="notification"></span>
            <img class="mobile-basket__img" src="{{ asset('images/svgs/cart.svg') }}" alt="Basket"/>
          </a>
        </div>

        <div class="col-lg-7 col-md-9 col-sm-8 no-pad-lg">
          <div class="header-rightside">
            <div class="hidden-xs hidden-sm">
              <div class="row no-mar">
                <div class="col-md-6 col-xs-12 no-pad">
                  <form method="GET" action="{{ route('search') }}" class="header-rightside__search input-grouped">
                    <input type="search" name="search_keyword" value="{{ old('search_keyword') }}" maxlength="25"
                           placeholder="Search fabrics, wallpaper and accessories or designer by their first or last name"/>
                    <button>&nbsp;</button>
                  </form>
                </div>
                <div class="col-md-6 col-xs-12 no-pad boot-style">
                  <div class="header-rightside-basket">
                    @include('includes.basket.index')
                  </div>
                  <form class="chnage-currency-form" action="{{ route('change.currency') }}" method="POST">
                    {{ csrf_field() }}
                    <select class="header-rightside__select field-primary fancy-dropdown auto-select currency"
                            name="currency" data-value="{{ getCurrentCurrency()->id }}">
                      {!! generateCurrencyDropdownOptions() !!}
                    </select>
                  </form>
                  @if (isCustomerUser())
                    <form action="{{ route('logout') }}" method="POST">
                      {{ csrf_field() }}
                      <button class="header-rightside__link" type="submit">Log Out</button>
                    </form>
                  @else
                    <a class="header-rightside__link" href="{{ route('view.login') }}">Log In / Sign Up</a>
                  @endif
                </div>
              </div>

              <div class="row no-mar">
                <div class="col-md-12 no-pad">
                  <ul class="header-rightside-list">
                    <li class="header-rightside-list__item">
                      <a href="{{ route('view.how.it.works') }}">The Process</a>
                    </li>
                    <li class="header-rightside-list__item">
                      <a href="{{ route('view.products') }}">Products</a>
                    </li>
                    <li class="header-rightside-list__item">
                      <div class="hover-init">
                        <a href="{{ route('view.faqs') }}">Help</a>
                        <div class="menu menu-text">
                          <h3 class="menu-text__hdr">Need Help?</h3>
                          <ul class="menu-text-list">
                            <li class="item"><a href="{{ route('view.delivery.and.returns') }}">Delivery &amp;
                                Returns</a></li>
                            <li class="item"><a href="{{ route('view.faqs') }}">FAQs</a></li>
                            <li class="item"><a href="{{ route('view.terms.and.conditions') }}">Terms &amp;
                                Conditions</a></li>
                            <li class="item"><a href="{{ route('view.privacy') }}">Privacy</a></li>
                            <li class="item"><a href="{{ route('view.design.tips') }}">Design Tips</a></li>
				<li class="item"><a href="{{ route('view.faqs') }}">Price Lists</a></li>
                          </ul>
                        </div>
                      </div>
                    </li>
                    <li class="header-rightside-list__item">
                      <a href="{{ route('view.contact') }}">Contact</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  @if(!empty($menu))
    @include('includes.header-menu.menu')
  @else
    <section class="header-menu">
      <div class="container container-global">
        <div class="row">
          <div class="col-sm-12 no-pad clearfix">

            <ul class="header-menu-list hidden-sm hidden-xs clearfix">
              <li class="js-hover-info-container header-menu-list__item hover-init">

                <a class="link-bracket-hover" href="{{ route('view.design.create') }}">Create</a>

                <div class="menu menu-sub">
                  <div class="row">
                    <div class="col-xs-12">
                      <h2 class="menu-sub__hdr">Create your own</h2>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-12 no-pad full-height">
                      <div class="col-xs-4">
                        <ul class="menu-sub-list">
                          <li class="js-item item active"><a href="{{ route('view.design.upload') }}">Custom Fabric</a>
                          </li>
                          <li class="js-item item"><a href="{{ route('view.design.upload') }}">Custom Wallpaper</a></li>
                          <li class="js-item item"><a href="{{ route('view.design.upload') }}">Custom Gift Wrap</a></li>
                          <li class="js-item item"><a href="{{ route('view.design.upload') }}">Custom Cushions</a></li>
                          <li class="js-item item"><a href="{{ route('view.design.upload') }}">Custom Aprons</a></li>
                          <li class="js-item item"><a href="{{ route('view.design.upload') }}">Custom Tea Towels</a>
   			 <li class="js-item item"><a href="{{ route('view.design.upload') }}">Sample your design</a>
                          </li>
			<li class="js-item item"><a href="{{ route('view.shop.colour.atlas') }}">Order Colour Atlas</a></li>
			<li class="js-item item"><a href="{{ route('view.shop.sample.books') }}">Order Sample Book</a></li>
                          <li class="js-item item"><a href="{{ route('view.custom.printing') }}">How to Custom Print</a>
                          </li>
                        </ul>
                      </div>
                      <div class="col-xs-8 pull-right">
                        <div class="js-hover-info menu-sub-content active">
                          <h3 class="menu-sub-content__hdr">
                            Custom Fabric
                          </h3>
                          <div class="menu-sub-content__img"
                               style="background-image: url('{{ asset('images/fashion.png') }}');"></div>
                          <p class="menu-sub-content__para">Create quilting, apparel and upholstery fabrics</p>
                          <a href="{{ route('view.design.upload') }}" class="menu-sub-content__link link-arrow-major">View
                            Page</a>
                        </div>
                        <div class="js-hover-info menu-sub-content">
                          <h3 class="menu-sub-content__hdr">
                            Custom Wallpaper
                          </h3>
                          <div class="menu-sub-content__img"
                               style="background-image: url('{{ asset('images/fashion.png') }}');"></div>
                          <p class="menu-sub-content__para">Create stunning wallpapers with your own designs</p>
                          <a href="{{ route('view.design.upload') }}" class="menu-sub-content__link link-arrow-major">View
                            Page</a>
                        </div>
                        <div class="js-hover-info menu-sub-content">
                          <h3 class="menu-sub-content__hdr">
                            Custom Gift Wrap
                          </h3>
                          <div class="menu-sub-content__img"
                               style="background-image: url('{{ asset('images/fashion.png') }}');"></div>
                          <p class="menu-sub-content__para">Design your own giftwrap for a unique present</p>
                          <a href="{{ route('view.design.upload') }}" class="menu-sub-content__link link-arrow-major">View
                            Page</a>
                        </div>
                        <div class="js-hover-info menu-sub-content">
                          <h3 class="menu-sub-content__hdr">
                            Custom Cushions
                          </h3>
                          <div class="menu-sub-content__img"
                               style="background-image: url('{{ asset('images/fashion.png') }}');"></div>
                          <p class="menu-sub-content__para">Create high quality cushions from luxurious interiors fabrics</p>
                          <a href="{{ route('view.design.upload') }}" class="menu-sub-content__link link-arrow-major">View
                            Page</a>
                        </div>
                        <div class="js-hover-info menu-sub-content">
                          <h3 class="menu-sub-content__hdr">
                            Custom Aprons
                          </h3>
                          <div class="menu-sub-content__img"
                               style="background-image: url('{{ asset('images/fashion.png') }}');"></div>
                          <p class="menu-sub-content__para">Create quilting, apparel and upholstery fabrics</p>
                          <a href="{{ route('view.design.upload') }}" class="menu-sub-content__link link-arrow-major">View
                            Page</a>
                        </div>
                        <div class="js-hover-info menu-sub-content">
                          <h3 class="menu-sub-content__hdr">
                            Custom Tea Towels
                          </h3>
                          <div class="menu-sub-content__img"
                               style="background-image: url('{{ asset('images/fashion.png') }}');"></div>
                          <p class="menu-sub-content__para">Design your own teatowels with illustrations, photos or patterns</p>
                          <a href="{{ route('view.design.upload') }}" class="menu-sub-content__link link-arrow-major">View
                            Page</a>
                        </div>
			<div class="js-hover-info menu-sub-content">
                          <h3 class="menu-sub-content__hdr">
                            Sample your designs
                          </h3>
                          <div class="menu-sub-content__img"
                               style="background-image: url('{{ asset('images/fashion.png') }}');"></div>
                          <p class="menu-sub-content__para">Print a 20 x 20 cm sample of your photo, illustration or design on over 100 fabrics and papers</p>
                          <a href="{{ route('view.design.upload') }}" class="menu-sub-content__link link-arrow-major">View
                            Page</a>
                        </div>
			<div class="js-hover-info menu-sub-content">
                          <h3 class="menu-sub-content__hdr">
                            Colour Atlas
                          </h3>
                          <div class="menu-sub-content__img"
                               style="background-image: url('{{ asset('images/colour-chart.png') }}');"></div>
                          <p class="menu-sub-content__para">Purchase a colour atlas to help you design and colour-match
                            your patterns</p>
                          <a href="{{ route('view.shop.colour.atlas') }}"
                             class="menu-sub-content__link link-arrow-major">View Page</a>
                        </div>
                        <div class="js-hover-info menu-sub-content">
                          <h3 class="menu-sub-content__hdr">
                            Sample book
                          </h3>
                          <div class="menu-sub-content__img"
                               style="background-image: url('{{ asset('images/sample-book-FF.jpg') }}');"></div>
                          <p class="menu-sub-content__para">Purchase a sample book to see all the bases we print
                            upon</p>
                          <a href="{{ route('view.shop.sample.books') }}"
                             class="menu-sub-content__link link-arrow-major">View Page</a>
                        </div>
                        <div class="js-hover-info menu-sub-content">
                          <h3 class="menu-sub-content__hdr">
                            How to Custom Print
                          </h3>
                          <div class="menu-sub-content__img"
                               style="background-image: url('{{ asset('images/print-paper.png') }}');"></div>
                          <p class="menu-sub-content__para">Printing your own textiles and wallpaper couldn't be easier.
                            Simply upload the image you want to produce, select the repeat layout and the fabric…and off
                            you go.</p>
                          <a href="{{ route('view.custom.printing') }}" class="menu-sub-content__link link-arrow-major">View
                            Page</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="js-hover-info-container header-menu-list__item hover-init">

                <a class="link-bracket-hover" href="{{ route('view.shop') }}">Shop</a>

                <div class="menu menu-sub menu-sub--slim">
                  <div class="row">
                    <div class="col-xs-12">
                      <h2 class="menu-sub__hdr">Shop for Products</h2>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-12 no-pad full-height">
                      <div class="col-xs-6 height-fix">
                        <ul class="menu-sub-list">
                          <li class="js-item item active"><a href="{{ route('view.shop.all') }}">Shop All</a></li>
                          <li class="js-item item"><a href="{{ route('view.shop.all', ['category' => 1]) }}">Shop
                              Fabric</a></li>
                          <li class="js-item item"><a href="{{ route('view.shop.all', ['category' => 2]) }}">Shop
                              Wallpaper</a></li>
                          <li class="js-item item"><a href="{{ route('view.shop.all', ['category' => 3]) }}">Shop Gift
                              Wrap</a></li>
                          <li class="js-item item"><a href="{{ route('view.shop.all', ['category' => 4]) }}">Shop
                              Cushions</a></li>
                          <li class="js-item item"><a href="{{ route('view.shop.all', ['category' => 4]) }}">Shop
                              Aprons</a></li>
                          <li class="js-item item"><a href="{{ route('view.shop.all', ['category' => 4]) }}">Shop Tea
                              Towels</a></li>
 			<li class="js-item item"><a href="{{ route('view.shop.all', ['category' => 4]) }}">Shop Blankets</a></li>
                          <li class="js-item item"><a href="{{ route('view.shop.colour.atlas') }}">Colour Atlas</a></li>
                          <li class="js-item item"><a href="{{ route('view.shop.sample.books') }}">Sample Books</a></li>
                          <li class="js-item item"><a href="{{ route('view.shop.plain.fabrics') }}">Shop Unprinted Fabric</a>
                          </li>
                        </ul>
                      </div>
                      <div class="col-xs-6 pull-right">
                        <div class="js-hover-info menu-sub-content active">
                          <h3 class="menu-sub-content__hdr">
                            Shop All
                          </h3>
                          <div class="menu-sub-content__img"
                               style="background-image: url('{{ asset('images/dress.png') }}');"></div>
                          <p class="menu-sub-content__para">Purchase fabrics, wallpaper, giftwrap and accessories with
                            designs from our talented indie community</p>
                          <a href="{{ route('view.shop.all') }}" class="menu-sub-content__link link-arrow-major">View
                            Page</a>
                        </div>
                        <div class="js-hover-info menu-sub-content">
                          <h3 class="menu-sub-content__hdr">
                            Shop Fabric
                          </h3>
                          <div class="menu-sub-content__img"
                               style="background-image: url('{{ asset('images/dress.png') }}');"></div>
                          <p class="menu-sub-content__para">Purchase fabrics, wallpaper, giftwrap and accessories with
                            designs from our talented indie community</p>
                          <a href="{{ route('view.shop.all', ['category' => 1]) }}"
                             class="menu-sub-content__link link-arrow-major">View Page</a>
                        </div>
                        <div class="js-hover-info menu-sub-content">
                          <h3 class="menu-sub-content__hdr">
                            Shop Wallpaper
                          </h3>
                          <div class="menu-sub-content__img"
                               style="background-image: url('{{ asset('images/dress.png') }}');"></div>
                          <p class="menu-sub-content__para">Purchase fabrics, wallpaper, giftwrap and accessories with
                            designs from our talented indie community</p>
                          <a href="{{ route('view.shop.all', ['category' => 2]) }}"
                             class="menu-sub-content__link link-arrow-major">View Page</a>
                        </div>
                        <div class="js-hover-info menu-sub-content">
                          <h3 class="menu-sub-content__hdr">
                            Shop Gift Wrap
                          </h3>
                          <div class="menu-sub-content__img"
                               style="background-image: url('{{ asset('images/dress.png') }}');"></div>
                          <p class="menu-sub-content__para">Purchase fabrics, wallpaper, giftwrap and accessories with
                            designs from our talented indie community</p>
                          <a href="{{ route('view.shop.all', ['category' => 3]) }}"
                             class="menu-sub-content__link link-arrow-major">View Page</a>
                        </div>
                        <div class="js-hover-info menu-sub-content">
                          <h3 class="menu-sub-content__hdr">
                            Shop Cushions
                          </h3>
                          <div class="menu-sub-content__img"
                               style="background-image: url('{{ asset('images/dress.png') }}');"></div>
                          <p class="menu-sub-content__para">Purchase fabrics, wallpaper, giftwrap and accessories with
                            designs from our talented indie community</p>
                          <a href="{{ route('view.shop.all', ['category' => 4]) }}"
                             class="menu-sub-content__link link-arrow-major">View Page</a>
                        </div>
                        <div class="js-hover-info menu-sub-content">
                          <h3 class="menu-sub-content__hdr">
                            Shop Aprons
                          </h3>
                          <div class="menu-sub-content__img"
                               style="background-image: url('{{ asset('images/dress.png') }}');"></div>
                          <p class="menu-sub-content__para">Purchase fabrics, wallpaper, giftwrap and accessories with
                            designs from our talented indie community</p>
                          <a href="{{ route('view.shop.all', ['category' => 4]) }}"
                             class="menu-sub-content__link link-arrow-major">View Page</a>
                        </div>
                        <div class="js-hover-info menu-sub-content">
                          <h3 class="menu-sub-content__hdr">
                            Shop Tea Towels
                          </h3>
                          <div class="menu-sub-content__img"
                               style="background-image: url('{{ asset('images/dress.png') }}');"></div>
                          <p class="menu-sub-content__para">Purchase unique tea towels with
                            designs from our talented indie community</p>
                          <a href="{{ route('view.shop.all', ['category' => 4]) }}"
                             class="menu-sub-content__link link-arrow-major">View Page</a>
                        </div>
  			<div class="js-hover-info menu-sub-content">
                          <h3 class="menu-sub-content__hdr">
                            Shop Blankets
                          </h3>
                          <div class="menu-sub-content__img"
                               style="background-image: url('{{ asset('images/dress.png') }}');"></div>
                          <p class="menu-sub-content__para">Purchase fabrics, wallpaper, giftwrap and accessories with
                            designs from our talented indie community</p>
                          <a href="{{ route('view.shop.all', ['category' => 4]) }}"
                             class="menu-sub-content__link link-arrow-major">View Page</a>
                        </div>
                        <div class="js-hover-info menu-sub-content">
                          <h3 class="menu-sub-content__hdr">
                            Colour Atlas
                          </h3>
                          <div class="menu-sub-content__img"
                               style="background-image: url('{{ asset('images/colour-chart.png') }}');"></div>
                          <p class="menu-sub-content__para">Purchase a colour atlas to help you design and colour-match
                            your patterns</p>
                          <a href="{{ route('view.shop.colour.atlas') }}"
                             class="menu-sub-content__link link-arrow-major">View Page</a>
                        </div>
                        <div class="js-hover-info menu-sub-content">
                          <h3 class="menu-sub-content__hdr">
                            Sample book
                          </h3>
                          <div class="menu-sub-content__img"
                               style="background-image: url('{{ asset('images/sample-book-FF.jpg') }}');"></div>
                          <p class="menu-sub-content__para">Purchase a sample book to see all the bases we print
                            upon</p>
                          <a href="{{ route('view.shop.sample.books') }}"
                             class="menu-sub-content__link link-arrow-major">View Page</a>
                        </div>
                        <div class="js-hover-info menu-sub-content">
                          <h3 class="menu-sub-content__hdr">
                            Plain Unprinted Fabric
                          </h3>
                          <div class="menu-sub-content__img"
                               style="background-image: url('{{ asset('images/dress.png') }}');"></div>
                          <p class="menu-sub-content__para">Buy plain fabric meterage to match and complete your printed
                            fabric project</p>
                          <a href="{{ route('view.shop.plain.fabrics') }}"
                             class="menu-sub-content__link link-arrow-major">View Page</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="js-hover-info-container header-menu-list__item hover-init">

                <a class="link-bracket-hover" href="{{ route('view.community') }}">Inspiration / Blog</a>

                <div class="menu menu-sub menu-sub--slim">
                  <div class="row">
                    <div class="col-xs-12">
                      <h2 class="menu-sub__hdr">Explore our Community</h2>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-12 no-pad full-height">
                      <div class="col-xs-6 height-fix">
                        <ul class="menu-sub-list">
                          <li class="js-item item active"><a href="{{ route('view.community') }}">Community</a></li>
                          <li class="js-item item"><a href="{{ route('view.weekly.contest') }}">Weekly Contest</a></li>
                          <li class="js-item item"><a href="{{ route('view.blog') }}">Blog</a></li>
                          <li class="js-item item"><a href="{{ route('view.design.tips') }}">Design Tips</a></li>
                          <li class="js-item item"><a href="{{ route('view.faqs') }}">FAQs</a></li>
			<li class="js-item item"><a href="{{ route('view.faqs') }}">Price Lists</a></li>
                        </ul>
                      </div>
                      <div class="col-xs-6 pull-right">
                        <div class="js-hover-info menu-sub-content active">
                          <h3 class="menu-sub-content__hdr">
                            Community
                          </h3>
                          <div class="menu-sub-content__img"
                               style="background-image: url('{{ asset('images/dress.png') }}');"></div>
                          <p class="menu-sub-content__para">Visit our community homepage for makers, creatives and
                            independent designers</p>
                          <a href="{{ route('view.community') }}" class="menu-sub-content__link link-arrow-major">View
                            Page</a>
                        </div>
                        <div class="js-hover-info menu-sub-content">
                          <h3 class="menu-sub-content__hdr">
                            Weekly Contest
                          </h3>
                          <div class="menu-sub-content__img"
                               style="background-image: url('{{ asset('images/woman-in-glasses.png') }}');"></div>
                          <p class="menu-sub-content__para">Visit our weekly contest page to vote for participating
                            designer's designs</p>
                          <a href="{{ route('view.weekly.contest') }}" class="menu-sub-content__link link-arrow-major">View
                            Page</a>
                        </div>
                        <div class="js-hover-info menu-sub-content">
                          <h3 class="menu-sub-content__hdr">
                            Blog
                          </h3>
                          <div class="menu-sub-content__img"
                               style="background-image: url('{{ asset('images/smartphone-laptop.png') }}');"></div>
                          <p class="menu-sub-content__para">View the latest news, tips and information of the company
                            and our design community</p>
                          <a href="{{ route('view.blog') }}" class="menu-sub-content__link link-arrow-major">View
                            Page</a>
                        </div>
                        <div class="js-hover-info menu-sub-content">
                          <h3 class="menu-sub-content__hdr">
                            Design Tips
                          </h3>
                          <div class="menu-sub-content__img"
                               style="background-image: url('{{ asset('images/ruler-line.png') }}');"></div>
                          <p class="menu-sub-content__para">Find helpful and informative tips to help you create the
                            perfect design and printed project</p>
                          <a href="{{ route('view.design.tips') }}" class="menu-sub-content__link link-arrow-major">View
                            Page</a>
                        </div>
                        <div class="js-hover-info menu-sub-content">
                          <h3 class="menu-sub-content__hdr">
                            FAQs
                          </h3>
                          <div class="menu-sub-content__img"
                               style="background-image: url('{{ asset('images/shirt.png') }}');"></div>
                          <p class="menu-sub-content__para">See the most Frequently Asked Questions about our
                            service</p>
                          <a href="{{ route('view.faqs') }}" class="menu-sub-content__link link-arrow-major">View
                            Page</a>
                        </div>
 			<div class="js-hover-info menu-sub-content">
                          <h3 class="menu-sub-content__hdr">
                            Price Lists
                          </h3>
                          <div class="menu-sub-content__img"
                               style="background-image: url('{{ asset('images/shirt.png') }}');"></div>
                          <p class="menu-sub-content__para">See and download prices for all our fabrics,wallpapers and home products</p>
                          <a href="{{ route('view.faqs') }}" class="menu-sub-content__link link-arrow-major">View
                            Page</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </li>
              <li class="js-hover-info-container header-menu-list__item hover-init">

                @if (isCustomerUser())
                  <a class="link-bracket-hover" href="{{ route('view.user.studio') }}">My Studio</a>

                  <div class="menu menu-sub menu-sub--slim">
                    <div class="row">
                      <div class="col-xs-12">
                        <h2 class="menu-sub__hdr">Manage your Account</h2>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12 no-pad full-height">
                        <div class="col-xs-6 height-fix">
                          <ul class="menu-sub-list">
                            <li class="js-item item"><a href="{{ route('view.user.studio') }}">My Studio</a></li>
                            <li class="js-item item"><a href="{{ route('view.user.designs') }}">My Designs</a></li>
                            <li class="js-item item"><a
                                  href="{{ route('view.designer.store', ['username' => getAuthenticatedUser()->studio->username]) }}">My
                                Shop</a></li>
                            <li class="js-item item"><a href="{{ route('view.user.favorites') }}">Favorites</a></li>
                            <li class="js-item item"><a href="{{ route('view.orders') }}">My Orders / Sales</a></li>
                            <li class="js-item item"><a href="{{ route('edit.user.shop') }}">Edit My Shop</a></li>
                            <li class="js-item item"><a href="{{ route('view.user.promotion') }}">Promote Your
                                Studio</a></li>
                            <li class="js-item item active"><a href="{{ route('view.user.account') }}">Account
                                Settings</a></li>
                          </ul>
                        </div>
                        <div class="col-xs-6 pull-right">
                          <div class="js-hover-info menu-sub-content">
                            <h3 class="menu-sub-content__hdr">
                              My Studio
                            </h3>
                            <div class="menu-sub-content__img"
                                 style="background-image: url('{{ asset('images/woman-in-glasses.png') }}');"></div>
                            <p class="menu-sub-content__para">Overview of your designs, favorites, orders and sales</p>
                            <a href="{{ route('view.user.studio') }}" class="menu-sub-content__link link-arrow-major">View
                              Page</a>
                          </div>
                          <div class="js-hover-info menu-sub-content">
                            <h3 class="menu-sub-content__hdr">
                              My Designs
                            </h3>
                            <div class="menu-sub-content__img"
                                 style="background-image: url('{{ asset('images/smartphone-laptop.png') }}');"></div>
                            <p class="menu-sub-content__para">View all your uploaded designs and projects</p>
                            <a href="{{ route('view.user.designs') }}" class="menu-sub-content__link link-arrow-major">View
                              Page</a>
                          </div>
                          <div class="js-hover-info menu-sub-content">
                            <h3 class="menu-sub-content__hdr">
                              My Shop
                            </h3>
                            <div class="menu-sub-content__img"
                                 style="background-image: url('{{ asset('images/woman-in-glasses.png') }}');"></div>
                            <p class="menu-sub-content__para">View your own personal E-Commerce shop</p>
                            <a href="{{ route('view.designer.store', ['username' => getAuthenticatedUser()->studio->username]) }}"
                               class="menu-sub-content__link link-arrow-major">View Page</a>
                          </div>
                          <div class="js-hover-info menu-sub-content">
                            <h3 class="menu-sub-content__hdr">
                              Favorites
                            </h3>
                            <div class="menu-sub-content__img"
                                 style="background-image: url('{{ asset('images/woman-in-glasses.png') }}');"></div>
                            <p class="menu-sub-content__para">See all your favorite selected patterns from other
                              designers</p>
                            <a href="{{ route('view.user.favorites') }}"
                               class="menu-sub-content__link link-arrow-major">View Page</a>
                          </div>
                          <div class="js-hover-info menu-sub-content">
                            <h3 class="menu-sub-content__hdr">
                              Orders / Sales
                            </h3>
                            <div class="menu-sub-content__img"
                                 style="background-image: url('{{ asset('images/dress.png') }}');"></div>
                            <p class="menu-sub-content__para">View your recent orders and pattern sales</p>
                            <a href="{{ route('view.orders') }}" class="menu-sub-content__link link-arrow-major">View
                              Page</a>
                          </div>
                          <div class="js-hover-info menu-sub-content">
                            <h3 class="menu-sub-content__hdr">
                              Edit Shop
                            </h3>
                            <div class="menu-sub-content__img"
                                 style="background-image: url('{{ asset('images/ruler-line.png') }}');"></div>
                            <p class="menu-sub-content__para">Edit your own personal E-Commerce shop</p>
                            <a href="{{ route('edit.user.shop') }}" class="menu-sub-content__link link-arrow-major">View
                              Page</a>
                          </div>
                          <div class="js-hover-info menu-sub-content">
                            <h3 class="menu-sub-content__hdr">
                              Edit Shop
                            </h3>
                            <div class="menu-sub-content__img"
                                 style="background-image: url('{{ asset('images/smartphone-laptop.png') }}');"></div>
                            <p class="menu-sub-content__para">Have your studio promoted on a blog or your website using
                              our Fashion Formula widgets or build your own widget using your designs!</p>
                            <a href="{{ route('view.user.promotion') }}"
                               class="menu-sub-content__link link-arrow-major">Promote your studio</a>
                          </div>
                          <div class="js-hover-info menu-sub-content active">
                            <h3 class="menu-sub-content__hdr">
                              Account Settings
                            </h3>
                            <div class="menu-sub-content__img"
                                 style="background-image: url('{{ asset('images/dress.png') }}');"></div>
                            <p class="menu-sub-content__para">Change your account settings</p>
                            <a href="{{ route('view.user.account') }}" class="menu-sub-content__link link-arrow-major">View
                              Page</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @else
                  <a class="link-bracket-hover" href="{{ route('view.contribute') }}">Sell</a>
                @endif

              </li>
            </ul>

          </div>
        </div>
      </div>
    </section>
  @endif
</header>
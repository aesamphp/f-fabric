<div class="js-mobile-menu mobile-menu visible-xs visible-sm">
    <div class="mobile-head">
        <div class="row no-mar">
            <div class="col-xs-12 no-pad">
                <div class="js-menu-cancel mobile-head-cross">
                    <img src="{{ asset('images/svgs/cross.svg') }}">
                </div>
                <div class="mobile-head-logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="Fashion Formula" />
                    </a>
                </div>
                <div class="mobile-head-select">
                    <form class="chnage-currency-form" action="{{ route('change.currency') }}" method="POST">
                        {{ csrf_field() }}
                        <select class="field-primary fancy-dropdown auto-select currency" name="currency" data-value="{{ getCurrentCurrency()->id }}">
                            {!! generateCurrencyDropdownOptions() !!}
                        </select>  
                    </form>                  
                </div>
            </div>
        </div> 	
        <div class="row no-mar">
            <div class="col-xs-12 no-pad">
                <form method="GET" action="{{ route('search') }}" class="input-grouped mobile-head-search">
                    <input type="text" name="search_keyword" value="{{ old('search_keyword') }}" maxlength="25" placeholder="Search fabrics, wallpaper and accessories" />
                    <button>&nbsp;</button>
                </form>        		
            </div>
        </div>
    </div>

    <div class="mobile-body">   	
        <div class="mobile-body-menu" data-destroy-desktop="true">
            
            @if (isCustomerUser())
            <form action="{{ route('logout') }}" method="POST">
                {{ csrf_field() }}
                <button class="mobile-body-menu__featured-btn" type="submit">Log Out</button>
            </form>
            @else
            <a href="{{ route('view.login') }}" class="mobile-body-menu__featured-btn">Log In / Sign Up</a>
            @endif
            
            <div class="accordion">
                <p class="mobile-body-menu__btn">Create</p>
                <div>
                    <ul class="mobile-inner-menu">
                        <li class="mobile-inner-menu__item">
                            <a href="{{ route('view.design.upload') }}">Custom Fabric</a>
                        </li>
                        <li class="mobile-inner-menu__item">
                            <a href="{{ route('view.design.upload') }}">Custom Wallpaper</a>
                        </li>
                        <li class="mobile-inner-menu__item">
                            <a href="{{ route('view.design.upload') }}">Custom Gift Wrap</a>
                        </li>
                        <li class="mobile-inner-menu__item">
                            <a href="{{ route('view.design.upload') }}">Custom Cushions</a>
                        </li>
                        <li class="mobile-inner-menu__item">
                            <a href="{{ route('view.design.upload') }}">Custom Aprons</a>
                        </li>
                        <li class="mobile-inner-menu__item">
                            <a href="{{ route('view.design.upload') }}">Custom Tea Towels</a>
                        </li>
                        <li class="mobile-inner-menu__item">
                            <a href="{{ route('view.custom.printing') }}">How to Custom Print</a>
                        </li>		                                        	                    	                    
                    </ul>
                </div>    		
                <p class="mobile-body-menu__btn">Shop</p>
                <div>
                    <ul class="mobile-inner-menu">
                        <li class="mobile-inner-menu__item">
                            <a href="{{ route('view.shop.all') }}">Shop All</a>
                        </li>
                        <li class="mobile-inner-menu__item">
                            <a href="{{ route('view.shop.all', ['category' => 1]) }}">Shop Fabric</a>
                        </li>
                        <li class="mobile-inner-menu__item">
                            <a href="{{ route('view.shop.all', ['category' => 2]) }}">Shop Wallpaper</a>
                        </li>
                        <li class="mobile-inner-menu__item">
                            <a href="{{ route('view.shop.all', ['category' => 3]) }}">Shop Gift Wrap</a>
                        </li>
                        <li class="mobile-inner-menu__item">
                            <a href="{{ route('view.shop.all', ['category' => 4]) }}">Shop Cushions</a>
                        </li>
                        <li class="mobile-inner-menu__item">
                            <a href="{{ route('view.shop.all', ['category' => 4]) }}">Shop Aprons</a>
                        </li>
                        <li class="mobile-inner-menu__item">
                            <a href="{{ route('view.shop.all', ['category' => 4]) }}">Shop Tea Towels</a>
                        </li>
                        <li class="mobile-inner-menu__item">
                            <a href="{{ route('view.shop.colour.atlas') }}">Colour Atlas</a>
                        </li>
                        <li class="mobile-inner-menu__item">
                            <a href="{{ route('view.shop.sample.books') }}">Sample Books</a>
                        </li>
                        <li class="mobile-inner-menu__item">
                            <a href="{{ route('view.shop.plain.fabrics') }}">Buy Unprinted Fabric</a>
                        </li>
                    </ul>
                </div>

                <p class="mobile-body-menu__btn">Community</a>  
                <div>
                    <ul class="mobile-inner-menu">
                        <li class="mobile-inner-menu__item">
                            <a href="{{ route('view.community') }}">Community</a>
                            <a href="{{ route('view.weekly.contest') }}">Weekly Contest</a>
                            <a href="{{ route('view.blog') }}">Blog</a>
                            <a href="{{ route('view.design.tips') }}">Design Tips</a>
                            <a href="{{ route('view.faqs') }}">FAQs</a>
                        </li>
                    </ul>
                </div>  

                @if (isCustomerUser())
                <p class="mobile-body-menu__btn">My Studio</p>
                <div>
                    <ul class="mobile-inner-menu">
                        <li class="mobile-inner-menu__item">
                            <a href="{{ route('view.user.studio') }}">My Studio</a>
                        </li>
                        <li class="mobile-inner-menu__item">
                            <a href="{{ route('view.user.designs') }}">My Designs</a>
                        </li>
                        <li class="mobile-inner-menu__item">
                            <a href="{{ route('view.designer.store', ['username' => getAuthenticatedUser()->studio->username]) }}">My Shop</a>
                        </li>
                        <li class="mobile-inner-menu__item">
                            <a href="{{ route('view.user.favorites') }}">Favorites</a>
                        </li>                        
                        <li class="mobile-inner-menu__item">
                            <a href="{{ route('view.orders') }}">My Orders / Sales</a>
                        </li>
                        <li class="mobile-inner-menu__item">
                            <a href="{{ route('edit.user.shop') }}">Edit Shop</a>
                        </li>
                        <li class="mobile-inner-menu__item">
                            <a href="{{ route('view.user.account') }}">Account Settings</a>
                        </li>
                    </ul>
                </div>
                @endif                                        
            </div>
            
            @if (!isCustomerUser())
            <a href="{{ route('view.contribute') }}" class="mobile-body-menu__btn no-arrow">Sell</a>
            @endif

        </div>
        <div class="mobile-body-submenu">
            <a href="{{ route('view.how.it.works') }}" class="mobile-body-submenu__link">The Process</a>
            <a href="{{ route('view.products') }}" class="mobile-body-submenu__link">Products</a>
            <a href="{{ route('view.faqs') }}" class="mobile-body-submenu__link">Help</a>
            <a href="{{ route('view.contact') }}" class="mobile-body-submenu__link">Contact</a>
        </div>
    </div>
</div>
<header>
    <nav class="top-nav teal">
        <div class="container">
            <div class="nav-wrapper">
                <a class="page-title truncate">@yield('page_title')</a>
            </div>
        </div>
    </nav>
    <div class="container">
        <a href="#" data-activates="nav-mobile" class="button-collapse top-nav full hide-on-large-only">
            <i class="mdi-navigation-menu"></i>
        </a>
    </div>
    @include('admin::includes.nav')
</header>
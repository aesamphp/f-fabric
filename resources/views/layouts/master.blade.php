<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('page_title') | Fashion Formula</title>
    <link type="text/css" rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('images/favicons/apple-touch-icon-57x57.png') }}" />
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('images/favicons/apple-touch-icon-60x60.png') }}" />
    <link rel="icon" type="image/png" href="{{ asset('images/favicons/favicon-32x32.png') }}" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{ asset('images/favicons/favicon-16x16.png') }}" sizes="16x16" />
    <link rel="manifest" href="{{ asset('images/favicons/manifest.json') }}" />
    <link rel="mask-icon" href="{{ asset('images/favicons/safari-pinned-tab.svg') }}" color="#5bbad5" />
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta name="theme-color" content="#ffffff" />
    @if (isEnvironment('production')) @include('includes.head-include') @endif
</head>
<body class="@yield('page_class')">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N5RRRBD"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    @yield('start_body')
    <div class="js-global-container global-container">
        @include('includes.top-sections')
        @yield('content')
    </div>
    <script type="text/javascript">
        @if (isAuthenticUser())
            window.intercomSettings = { app_id: "ie3j02vs", name:"{{ getAuthenticatedUser()->getFullName() }}", email: "{{ getAuthenticatedUser()->email }}", created_at: "{{ getAuthenticatedUser()->created_at }}" };
        @else
            window.intercomSettings = { app_id: "ie3j02vs" };
        @endif
    </script>
    @include('includes.js')
    <script type="text/javascript">App.run();</script>
    @yield('end_body')
</body>
</html>
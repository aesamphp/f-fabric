<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('page_title') | Administrator | Fashion Formula</title>
    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link type="text/css" rel="stylesheet" href="{{ asset('css/materialize.min.css') }}"  media="screen,projection" />
    <link type="text/css" rel="stylesheet" href="{{ asset('css/admin.css') }}"  media="screen,projection" />
</head>
<body class="admin-page @yield('page_class')">
    @yield('content')
    @include('includes.js')
    <script type="text/javascript" src="{{ asset('js/materialize.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admin.functions.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.tablednd.js') }}"></script>
    <script type="text/javascript">App.config.routes.adminURL = "{{ route('admin::dashboard') }}";</script>
    <script type="text/javascript">App.run();</script>
    @yield('end_body')
</body>
</html>
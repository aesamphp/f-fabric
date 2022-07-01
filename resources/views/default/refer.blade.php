@section('page_title', 'Refer')
@section('page_class', 'refer')

@extends('layouts.master')

@section('content')
@include('includes.mobile-nav')
@include('includes.header')

<!--- Begin Mention Me referrer placeholder div --->
<div id="mmWrapper"></div>
<!--- End Mention Me referrer placeholder div --->

<!--- Begin Mention Me referrer integration --->
<script type="text/javascript" src="
https://tag.mention-me.com/api/v2/referreroffer/mm4ff24c87?
implementation=embed&
situation=landingpage&
locale=en_GB"></script>
<!--- End Mention Me referrer integration --->

@include('includes.footer')

@stop
@section('page_title', 'Error 401')
@section('page_class', 'page-error-401')

@extends('layouts.master')

@section('content')
@include('includes.mobile-nav')
@include('includes.header')

<main>
    <div class="container container-global">
        <div class="row">
            <div class="container-dotted-pattern col-xs-12 no-pad">
                
                <section class="four-oh-four">
                    <h1 class="four-oh-four__hdr">Access Denied</h1>
                    <p class="four-oh-four__para">We’re sorry, you're not authorised to see this page.
                        <br /><br />Please return to the home page by clicking below. Thank you.
                    </p>
                    <a href="{{ route('home') }}" class="four-oh-four__btn btn-primary btn-primary--no-border"><span>Return Home</span></a>
                </section>

            </div>
        </div>
    </div>
</main>

@include('includes.footer')
@stop
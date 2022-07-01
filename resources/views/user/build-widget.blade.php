@section('page_title', 'Build Widget')
@section('page_class', 'build-widget')

@extends('layouts.master')

@section('content')
    @include('includes.mobile-nav')
    @include('includes.header')

    <main>
        <div class="container container-global build-widget">
            <div class="row">
                <div class="col-md-12 clearfix no-pad">
                    <section class="featured-banner featured-banner--designs">
                        <h1 class="featured-banner__hdr">Build your own Widget</h1>
                        <p>Build your own Fashion Formula widget and add it to your site or blog to show off your designs or favourite patterns to everyone. Get started now below to create the embeddable code.</p>
                    </section>
                </div>
            </div>

            <div class="col-xs-12 container-dotted-pattern">
                <div class="row">

                    <div class="col-md-12 boot-style">
                        <div class="col-md-12 clearfix no-pad">
                            <section class="design-approvals promote">
                                <form class="ajax-build-widget" method="POST" action="{{ route('user.build.widget.ajax') }}" autocomplete="off">
                                    {{ csrf_field() }}
                                    {{ method_field('POST') }}

                                    <h2>Which designs would you like to show?</h2>

                                    <div class="sort__check checkbox-container">
                                        <input name="designs" type="radio" value="my_shop" />
                                        <span class="checkbox-overlay"></span>
                                        <span class="checkbox-text">My shop</span>
                                    </div>

                                    <hr>

                                    <h2>How should the designs be displayed?</h2>

                                    <div class="sort__check checkbox-container">
                                        <input name="display" type="radio" value="small" />
                                        <span class="checkbox-overlay"></span>
                                        <span class="checkbox-text">Small</span>
                                    </div>

                                    <div class="sort__check checkbox-container">
                                        <input name="display" type="radio" value="large" />
                                        <span class="checkbox-overlay"></span>
                                        <span class="checkbox-text">Large</span>
                                    </div>

                                    <hr>

                                    <h2>In what order would you like the designs?</h2>

                                    <div class="sort__check checkbox-container">
                                        <input name="order" type="radio" value="random" />
                                        <span class="checkbox-overlay"></span>
                                        <span class="checkbox-text">Random</span>
                                    </div>

                                    <div class="sort__check checkbox-container">
                                        <input name="order" type="radio" value="new" />
                                        <span class="checkbox-overlay"></span>
                                        <span class="checkbox-text">New</span>
                                    </div>

                                    <hr>

                                    <h2>What should the layout look like?</h2>

                                    <div class="checkout-input-field field-group layout">
                                        <select id="layout" name="layout-columns">
                                            <option value="0">Please Select</option>
                                            <option value="1">1 columns</option>
                                            <option value="2">2 columns</option>
                                            <option value="3">3 columns</option>
                                            <option value="4">4 columns</option>
                                            <option value="5">5 columns</option>
                                        </select>
                                    </div>

                                    <div class="checkout-input-field field-group">
                                        <select id="layout" name="layout-rows">
                                            <option value="0">Please Select</option>
                                            <option value="1">1 rows</option>
                                            <option value="2">2 rows</option>
                                            <option value="3">3 rows</option>
                                            <option value="4">4 rows</option>
                                            <option value="5">5 rows</option>
                                        </select>
                                    </div>

                                    <button class="btn-primary btn-primary--no-border" type="submit"><span>Create Widget</span></button>
                                </form>

                                <div class="result hidden"></div>

                            </section>
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
        $('body').on('click', '.btn-tertiary--gray',function () {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($("body").find('.code-example').text()).select();
            document.execCommand("copy");
            $temp.remove();
        });
    </script>
@stop
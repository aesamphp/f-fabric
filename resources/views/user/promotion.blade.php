@section('page_title', 'My Studio')
@section('page_class', 'my-studio')

@extends('layouts.master')

@section('content')
    @include('includes.mobile-nav')
    @include('includes.header')

    <main>
        <div class="container container-global">
            <div class="row">
                <div class="col-md-12 clearfix no-pad">
                    <section class="featured-banner featured-banner--designs">
                        <h1 class="featured-banner__hdr">Promote your studio</h1>
                    </section>
                </div>
            </div>

            <div class="col-xs-12 container-dotted-pattern">
                <div class="row">

                    <div class="col-md-12 boot-style">
                        <div class="col-md-12 clearfix no-pad">
                            <section class="design-approvals promote">

                                <h2>Link to your studio</h2>
                                <span>Copy and Paste the code or click the button to add it to your clipboard.</span>

                                <div class="link-content">
                                    <button class="btn-tertiary--gray pull-right"><span>Copy to clipboard</span></button>

                                    <a href="{{ route('view.designer.store', ['username' => getAuthenticatedUser()->studio->username]) }}" target="_blank">
                                        <img src="{{ asset('images/promotion/BannerLarge.jpg') }}">
                                    </a>

                                    <div disabled="disabled" class="code-example">
                                        &lta href="{{ route('view.designer.store', ['username' => getAuthenticatedUser()->studio->username]) }}" target="_blank"&gt
                                            &ltimg src="{{ asset('images/promotion/BannerLarge.jpg') }}"/&gt
                                        &lt/a&gt
                                    </div>
                                </div>

                               <div class="link-content">
                                   <button class="btn-tertiary--gray pull-right"><span>Copy to clipboard</span></button>

                                   <a href="{{ route('view.designer.store', ['username' => getAuthenticatedUser()->studio->username]) }}" target="_blank">
                                       <img src="{{ asset('images/promotion/BannerSmall.jpg') }}">
                                   </a>

                                   <div disabled="disabled" class="code-example">
                                       &lta href="{{ route('view.designer.store', ['username' => getAuthenticatedUser()->studio->username]) }}" target="_blank"&gt
                                            &ltimg src="{{ asset('images/promotion/BannerSmall.jpg') }}"/&gt
                                       &lt/a&gt
                                   </div>
                               </div>

                               <hr>

                               <h2>Link to Fashion-Formula.com</h2>
                               <span>Copy and Paste the code or click the button to add it to your clipboard.</span>

                               <div class="link-content">
                                   <button class="btn-tertiary--gray pull-right"><span>Copy to clipboard</span></button>

                                   <a href="{{ route('home') }}" target="_blank">
                                       <img src="{{ asset('images/promotion/CherryLarge.jpg') }}">
                                   </a>

                                   <div disabled="disabled" class="code-example">
                                       &lta href="{{ route('home') }}" target="_blank"&gt
                                            &ltimg src="{{ asset('images/promotion/CherryLarge.jpg') }}"/&gt
                                       &lt/a&gt
                                   </div>
                               </div>

                               <div class="link-content">
                                   <button class="btn-tertiary--gray pull-right"><span>Copy to clipboard</span></button>

                                   <a href="{{ route('view.user.studio') }}" target="_blank">
                                       <img src="{{ asset('images/promotion/CherrySmall.jpg') }}">
                                   </a>

                                  <div disabled="disabled" class="code-example">
                                      &lta href="{{ route('home') }}" target="_blank"&gt
                                            &ltimg src="{{ asset('images/promotion/CherrySmall.jpg') }}"/&gt
                                      &lt/a&gt
                                  </div>
                               </div>

                               <div class="link-content">
                                   <button class="btn-tertiary--gray pull-right"><span>Copy to clipboard</span></button>

                                   <a href="{{ route('view.user.studio') }}" target="_blank">
                                       <img src="{{ asset('images/promotion/LogoLarge.jpg') }}">
                                   </a>

                                  <div disabled="disabled" class="code-example">
                                      &lta href="{{ route('home') }}" target="_blank"&gt
                                            &ltimg src="{{ asset('images/promotion/LogoSmall.jpg') }}https://www.fashion-formula.com/images/promotion/LogoLarge.jpg"/&gt
                                      &lt/a&gt
                                  </div>
                               </div>

                               <div class="link-content">
                                   <button class="btn-tertiary--gray pull-right"><span>Copy to clipboard</span></button>

                                   <a href="{{ route('view.user.studio') }}" target="_blank">
                                       <img src="{{ asset('images/promotion/LogoSmall.jpg') }}">
                                   </a>

                                  <div disabled="disabled" class="code-example">
                                      &lta href="{{ route('home') }}" target="_blank"&gt
                                            &ltimg src="{{ asset('images/promotion/LogoSmall.jpg') }}"/&gt
                                      &lt/a&gt
                                  </div>
                               </div>

                                <a class="btn-primary btn-primary" href="{{ route('view.user.build.widget') }}"><span>Build your own widget</span></a>

                            </section>
                        </div>
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
        $('.btn-tertiary--gray').click(function () {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(this).closest('.link-content').find('.code-example').text()).select();
            document.execCommand("copy");
            $temp.remove();
        });
    </script>
@stop

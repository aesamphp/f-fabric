@section('page_title', 'Dashboard')
@section('page_class', 'admin-dashboard sticky-footer')

@extends('admin::layouts.master')

@section('content')
@include('admin::includes.header')

<main class="sticky-footer">
    <div class="container">
        <div class="row">
            
            @include('includes.flash')

            <div class="col s12 col-lg-6">
                <div class="card-panel teal">
                    <h5 class="white-text">Recent Orders</h5>
                    <div class="collection">
                        <a href="#!" class="collection-item">Alvin</a>
                        <a href="#!" class="collection-item">Alvin</a>
                        <a href="#!" class="collection-item">Alvin</a>
                        <a href="#!" class="collection-item">Alvin</a>
                        <a href="#!" class="collection-item">Alvin</a>
                    </div>
                </div>
            </div>
            
            <div class="col s12 col-lg-6">
                <div class="card-panel teal">
                    <h5 class="white-text">Recent Customers</h5>
                    <div class="collection">
                        <a href="#!" class="collection-item">Alvin</a>
                        <a href="#!" class="collection-item">Alvin</a>
                        <a href="#!" class="collection-item">Alvin</a>
                        <a href="#!" class="collection-item">Alvin</a>
                        <a href="#!" class="collection-item">Alvin</a>
                    </div>
                </div>
            </div>
            
            <div class="col s12 col-lg-6">
                <div class="card-panel teal">
                    <h5 class="white-text">Recent Contributers</h5>
                    <div class="collection">
                        <a href="#!" class="collection-item">Alvin</a>
                        <a href="#!" class="collection-item">Alvin</a>
                        <a href="#!" class="collection-item">Alvin</a>
                        <a href="#!" class="collection-item">Alvin</a>
                        <a href="#!" class="collection-item">Alvin</a>
                    </div>
                </div>
            </div>
            
            <div class="col s12 col-lg-6">
                <div class="card-panel teal">
                    <h5 class="white-text">Recent Designs</h5>
                    <ul class="collection">
                        <li class="collection-item avatar">
                            <img class="circle" src="{{ asset('images/pattern1.png') }}" alt="Design" />
                            <span class="title">Title</span>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                        </li>
                        <li class="collection-item avatar">
                            <img class="circle" src="{{ asset('images/pattern2.png') }}" alt="Design" />
                            <span class="title">Title</span>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                        </li>
                        <li class="collection-item avatar">
                            <img class="circle" src="{{ asset('images/pattern3.png') }}" alt="Design" />
                            <span class="title">Title</span>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                        </li>
                    </ul>
                </div>
            </div>
            
        </div>
    </div>
</main>

@include('admin::includes.footer')
@stop
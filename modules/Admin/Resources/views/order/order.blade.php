@section('page_title', 'Order # ' . $order->friendly_id)
@section('page_class', 'admin-sales sticky-footer')

@extends('admin::layouts.master')

@section('content')
    @include('admin::includes.header')

    <main class="sticky-footer order-page">
        <div class="container">
            <div class="row">

                @include('includes.flash')

                <div class="col s12">
                    <div class="row">
                        <a class="btn grey lighten-1 waves-effect waves-light right" href="{{ route('admin::view.orders') }}">Back</a>
                        <a class="btn teal waves-effect waves-light right btn-push-left" href="{{ route('admin::print.order', ['id' => $order->id]) }}" target="_blank">Print</a>
                        <a class="btn teal waves-effect waves-light right btn-push-left" href="{{ route('admin::download.order.xml', ['id' => $order->id]) }}">Download XML</a>
                        @if (!$order->isDispatched())
                            <button type="button" class="btn teal waves-effect waves-light right btn-push-left btn-show-slidetoggle-container" data-container="dispatch-order-form">Dispatch</button>
                        @endif
                    </div>
                </div>

                @if (!$order->isDispatched())
                    <form id="dispatch-order-form" class="col s12 container-slidetoggle" method="POST" action="{{ route('admin::dispatch.order', ['id' => $order->id]) }}">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="row">
                            <div class="input-field col s12 m6">
                                <select id="dispatched" name="dispatched" class="material-select auto-select" data-value="{{ old('dispatched') }}">
                                    <option value="1">Yes</option>
                                </select>
                                <label for="dispatched">Dispatched</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <input id="tracking_number" type="text" name="tracking_number" class="validate" value="{{ old('tracking_number') }}" />
                                <label for="tracking_number">Tracking Number</label>
                            </div>
                            <div class="input-field col s12">
                                <button class="btn teal waves-effect waves-light right" type="submit">Save</button>
                                <button class="btn grey lighten-1 waves-effect waves-light right btn-push-left btn-hide-slidetoggle-container" type="button">Cancel</button>
                            </div>
                        </div>
                    </form>
                @endif

                <div class="col s12 no-padding">
                    <div class="col s12 col-lg-6">
                        <div class="card-panel teal">
                            <h5 class="white-text">Order Details</h5>
                            <div class="collection">
                                <p class="collection-item">Date: {{ formatDate($order->created_at) }}</p>
                                <p class="collection-item">Customer ID: <a href="{{ route('admin::view.contributor', ['id' => $order->user->id]) }}" title="View">{{ $order->user->friendly_id }}</a></p>
                                <p class="collection-item">Customer Name: @if(isset($order->user)) {{ $order->user->getFullName() }} @endif</p>
                                <p class="collection-item">Customer Email: @if(isset($order->user)) {{ $order->user->email }} @endif</p>
                                <p class="collection-item">Total: {{ formatPrice($order->getTotalAmount()) }}</p>
                                <p class="collection-item">Currency: {{ $order->currency }}</p>
                                <p class="collection-item">Status: {{ $order->getStatus() }}</p>
                                <p class="collection-item">Tracking Number: {{ ($order->tracking_number) ? $order->tracking_number : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col s12 col-lg-6">
                        <div class="card-panel teal">
                            <h5 class="white-text">Billing Details</h5>
                            <div class="collection">
                                @if(isset($order->billingAddress))
                                    <p class="collection-item">Name: {{ $order->billingAddress->getFullName() }}</p>
                                    <p class="collection-item">Address Line 1: {{ $order->billingAddress->address_line1 }}</p>
                                    @if ($order->billingAddress->address_line2)
                                        <p class="collection-item">Address Line 2: {{ $order->billingAddress->address_line2 }}</p>
                                    @endif
                                    <p class="collection-item">City:  {{ $order->billingAddress->city }}</p>
                                    <p class="collection-item">Postcode: {{ $order->billingAddress->postcode }}</p>
                                    <p class="collection-item">Country: {{ getCountry($order->billingAddress->country)->title }}</p>
                                    @if ($order->billingAddress->phone)
                                        <p class="collection-item">Phone: {{ $order->billingAddress->phone }}</p>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col s12 col-lg-6">
                    <div class="card-panel teal">
                        <h5 class="white-text">Shipping Details</h5>
                        <div class="collection">
                            @if(isset($order->shippingAddress))
                                <p class="collection-item">Name: {{ $order->shippingAddress->getFullName() }}</p>
                                <p class="collection-item">Address Line 1: {{ $order->shippingAddress->address_line1 }}</p>
                                @if ($order->shippingAddress->address_line2)
                                    <p class="collection-item">Address Line 2: {{ $order->shippingAddress->address_line2 }}</p>
                                @endif
                                <p class="collection-item">City: {{ $order->shippingAddress->city }}</p>
                                <p class="collection-item">Postcode: {{ $order->shippingAddress->postcode }}</p>
                                <p class="collection-item">Country: {{ getCountry($order->shippingAddress->country)->title }}</p>
                                @if ($order->shippingAddress->phone)
                                    <p class="collection-item">Phone: {{ $order->shippingAddress->phone }}</p>
                                @endif
                                <p class="collection-item">Branding: {{ $order->shippingAddress->branding->title }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <table class="responsive-table data-table">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($order->orderItems as $item)
                        <tr>
                            <td class="product">
                                @if ($item->isColourAtlas())
                                    <img class="materialboxed" src="{{ asset(getColourAtlasImagePath()) }}" alt="Image" />
                                @elseif ($item->isSampleBook())
                                    <img class="materialboxed" src="{{ asset(getSampleBookImagePath()) }}" alt="Image" />
                                @elseif ($item->isPlainFabric())
                                    <img class="materialboxed" src="{{ asset(getPlainFabricImagePath()) }}" alt="Image" />
                                @else
                                    <img class="materialboxed" src="{{ asset($item->design->getThumbnailImagePath()) }}" alt="Image" />
                                @endif
                                <p>{{ $item->getTitle() }}</p>
                                @if ($item->isDesign())
                                    <p>{{ $item->material->title . ' - ' . $item->product->title }}</p>
                                    <p>{{ $item->getRepeatType() }}, DPI - {{ $item->getDpi() }}</p>
                                    <p>#{{ $item->design->friendly_id }}</p>
                                @endif
                            </td>
                            <td>{{ $item->product->category->title }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $order->getCurrency()->symbol . formatPrice($item->getPrice()) }}</td>
                            <td>
                                @if ($item->isDesign())
                                    <a href="{{ route('admin::download.order.design.file', ['id' => $order->id, 'itemId' => $item->id]) }}" title="Download File">
                                        <i class="material-icons teal-icon">play_for_work</i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <table class="responsive-table data-table">
                    <tbody>
                    <tr>
                        <td class="text-right">
                            <p>Sub Total: {{ $order->getCurrency()->symbol . formatPrice($order->getSubtotalAmount()) }}</p>
                            @if ($order->hasDiscount())
                                <p>Discount: &ndash; {{ $order->getCurrency()->symbol . formatPrice($order->getDiscountAmount()) }}<br />{{ $order->getDiscountCode() }}</p>
                            @endif
                            <p>Delivery: {{ $order->getCurrency()->symbol . formatPrice($order->getShippingAmount()) }}</p>
                            @if ($order->surcharge > 0)
                                <p>Surcharge: {{ $order->getCurrency()->symbol . formatPrice($order->surcharge) }}</p>
                            @endif
                            <p>Total: {{ $order->getCurrency()->symbol . formatPrice($order->getTotalAmount()) }}</p>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </main>

    @include('admin::includes.footer')
@stop
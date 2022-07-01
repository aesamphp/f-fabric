<section class="checkout-header">
    <ul class="list">
        <li class="item{{ isActiveRoute('view.checkout.billing.address', ' item--current') }}"><a href="{{ route('view.checkout.billing.address') }}">Billing Address</a></li>
        <li class="item{{ isActiveRoute('view.checkout.delivery.address', ' item--current') }}"><a href="{{ route('view.checkout.delivery.address') }}">Delivery Address</a></li>
        <li class="item{{ isActiveRoute('view.checkout.payment', ' item--current') }}"><a href="{{ route('view.checkout.payment') }}">Payment</a></li>
        <li class="item{{ isActiveRoute('view.checkout.order.review', ' item--current') }}"><a href="{{ route('view.checkout.order.review') }}">Order Review</a></li>
    </ul>
</section>
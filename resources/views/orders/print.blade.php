<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <title>Order #{{ $order->friendly_id }} | Fashion Formula</title>
    <style type="text/css">
        table { border-collapse: collapse; border-spacing: 0; }
        .nth:nth-of-type(odd) { background-color: #F5F5F5; }
        ul { padding-left: 0; }
        li { list-style-type: none; padding-bottom: 3px; }
        ul.address { font-size: 14px; margin: 15px 0; }
        .btn-primary { background-color: #1bb5ae; color: #FFF; text-transform: uppercase; min-width: 200px; display: inline-block; padding: 12px 30px; font-size: .8125em; }
    </style>
    <script type="text/javascript">
        function printDocument() {
            document.getElementById('print-document').style.display = 'none';
            setTimeout(function() {
                window.print();
            }, 250);
        }
    </script>
</head>
<body>
    <table border="0" style="width: 100%; font-family: Arial; max-width: 1200px;">
        <tr>
            <td>
                <table style="width: 100%; margin-top: 15px;">
                    <tr>
                        <td>
                            <img src="{{ asset('images/logo.png') }}" alt="Fashion Formula" />
                            @if (!isEUCountry($order->shippingAddress->country))
                            <p style="font-weight:bold;font-size:16px;">Export</p>
                            @endif
                        </td>
                        <td>
                            <table style="float:right;">
                                <tr>
                                    <td style="font-weight:bold;font-size:16px;padding:3px 0;padding-right:10px;">Full Name:</td>
                                    <td>{{ $user->getFullName() }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:bold;font-size:16px;padding:3px 0;padding-right:10px;">Email Address:</td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                @if ($user->isVATRegistered())
                                <tr>
                                    <td style="font-weight:bold;font-size:16px;padding:3px 0;padding-right:10px;">VAT #:</td>
                                    <td>{{ $user->getVATNumber() }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td style="font-weight:bold;font-size:16px;padding:3px 0;padding-right:10px;">Order #:</td>
                                    <td>#{{ $order->friendly_id }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:bold;font-size:16px;padding:3px 0;padding-right:10px;">Date of Order:</td>
                                    <td>{{ formatDate($order->created_at, 'd/m/Y') }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table border="1" style="width:100%;margin-top:30px;margin-bottom:30px;font-size:14px;">
                    <tr style="background-color:#B1B1B1;font-weight:bold;">
                        <td style="padding-top:15px;padding-bottom:15px;padding-left:10px;" cellpadding="0">Product</td>
                        <td style="text-align:center;padding-top:15px;padding-bottom:15px;" cellpadding="0">Price</td>
                        <td style="text-align:center;padding-top:15px;padding-bottom:15px;" cellpadding="0">Qty</td> 
                        <td style="text-align:center;padding-top:15px;padding-bottom:15px;" cellpadding="0">Total</td>                           
                    </tr>                                     
                    @foreach ($order->orderItems as $item)
                    <tr class="nth">
                        <td style="padding: 5px;">
                            <table>
                                <tr>
                                    <td style="padding-right:5px;">
                                        @if ($item->isColourAtlas())
                                        <img src="{{ asset(getColourAtlasImagePath()) }}" width="100" height="100" style="vertical-align: middle;" />
                                        @elseif ($item->isSampleBook())
                                        <img src="{{ asset(getSampleBookImagePath()) }}" width="100" height="100" style="vertical-align: middle;" />
                                        @elseif ($item->isPlainFabric())
                                        <img src="{{ asset(getPlainFabricImagePath()) }}" width="100" height="100" style="vertical-align: middle;" />
                                        @else
                                        <img src="{{ asset($item->design->getThumbnailImagePath()) }}" width="100" height="100" style="vertical-align: middle;" />
                                        @endif
                                    </td>
                                    <td style="vertical-align:top;font-size:12px;">
                                        <table>
                                            <tr>
                                                <td style="font-weight:bold;">{{ $item->product->title }}</td>
                                            </tr>
                                            @if ($item->isDesign())
                                            <tr>
                                                <td>{{ $item->material->title . ' (' . $item->product->width_text . ' x ' . $item->product->height_text . ')' }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ $item->getRepeatType() }}, DPI - {{ $item->getDpi() }}</td>
                                            </tr>
                                            <tr>
                                                <td>Design Number: #{{ $item->design->friendly_id }}</td>
                                            </tr>
                                            @elseif ($item->isColourAtlas() || $item->isPlainFabric())
                                            <tr>
                                                <td>{{ $item->material->title }}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td>SKU - {{ $item->product->sku }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="text-align:center;font-size:12px;">
                            {{ $order->getCurrency()->symbol . formatPrice($item->unit_price) }}
                        </td>
                        <td style="text-align:center;font-size:12px;">
                            {{ $item->quantity }}
                        </td> 
                        <td style="text-align:center;font-size:12px;">
                            {{ $order->getCurrency()->symbol . formatPrice($item->getPrice()) }}
                        </td>                           
                    </tr>
                    @endforeach
                </table>
                <table border="0" style="width:100%;">
                    <tr>
                        <td>
                            <table border="1" style="width:300px;float: right;">
                                <tr>
                                    <td style="font-size:14px;font-weight:bold;padding:5px;background-color: #F5F5F5;">Sub Total:</td>
                                    <td style="padding:5px;text-align:right;">{{ $order->getCurrency()->symbol . formatPrice($order->getSubtotalAmount()) }}</td>
                                </tr>
                                @if ($order->hasDiscount())
                                <tr>
                                    <td style="font-size:14px;font-weight:bold;padding:5px;background-color: #F5F5F5;">Discount:</td>
                                    <td style="padding:5px;text-align:right;">&ndash; {{ $order->getCurrency()->symbol . formatPrice($order->getDiscountAmount()) }}<br />{{ $order->getDiscountCode() }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td style="font-size:14px;font-weight:bold;padding:5px;background-color: #F5F5F5;">Delivery:</td>
                                    <td style="padding:5px;text-align:right;">{{ getPriceText($order->getShippingAmount(), $order->getCurrency()->symbol) }}</td>
                                </tr>
                                @if ($order->hasVAT())
                                <tr>
                                    <td style="font-size:14px;font-weight:bold;padding:5px;background-color: #F5F5F5;">VAT:</td>
                                    <td style="padding:5px;text-align:right;">{{ $order->getCurrency()->symbol . formatPrice($order->vat) }}</td>
                                </tr>
                                @endif
                                @if ($order->surcharge > 0)
                                <tr>
                                    <td style="font-size:14px;font-weight:bold;padding:5px;background-color: #F5F5F5;">Surcharge:</td>
                                    <td style="padding:5px;text-align:right;">{{ $order->getCurrency()->symbol . formatPrice($order->surcharge) }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td style="font-weight:bold;padding:15px 5px;font-size:16px;background-color: #F5F5F5;">CART TOTAL:</td>
                                    <td style="padding:15px 5px;font-size:16px;text-align:right;" colspan="2">{{ $order->getCurrency()->symbol . formatPrice($order->getTotalAmount()) }}</td>
                                </tr>                                                                 
                            </table>
                        </td>
                    </tr>
                </table>
                <table border="0" style="width:100%;margin-top:30px;border-top: 2px solid #B1B1B1;border-bottom: 2px solid #B1B1B1;">
                    <tr>
                        <td style="padding: 0;">
                            <table style="width:100%;" border="0">
                                <tr>
                                    <td style="padding-left:15px;">
                                        <p style="font-weight:bold;">Delivery Address</p>
                                        {!! formatAddress($order->shippingAddress, $order->getAddressAttributes()) !!}
                                    </td>                                                                               
                                </tr>
                            </table>
                        </td>
                        <td style="padding: 0;">
                            <table style="width:100%;" border="0">
                                <tr>
                                    <td style="padding-left:15px;">
                                        <p style="font-weight:bold;">Billing Address</p>
                                        {!! formatAddress($order->billingAddress, $order->getAddressAttributes()) !!}
                                    </td>                                                                               
                                </tr>
                            </table>
                        </td>
                        <td valign="top" style="padding: 0;">
                            <table style="width:100%;" border="0">
                                <tr>
                                    <td style="padding-left:15px;">
                                        <p style="font-weight:bold;">Shipping Method</p>
                                        {{ $order->shippingAddress->branding->title }}
                                    </td>                                                                               
                                </tr>
                                <tr>
                                    <td style="padding-left:15px;padding-top:20px;">
                                        {!! $barcode !!}
                                        <p style="letter-spacing: 13px;">{{ $order->friendly_id }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table border="0" style="width:100%;margin-top:30px;">
                    <tr>
                        <td style="padding: 0; vertical-align: bottom;">
                            <button id="print-document" type="button" class="btn-primary" onclick="printDocument();">Print</button>
                        </td>
                        <td style="padding: 0; width: 30%;">
                            &nbsp;
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
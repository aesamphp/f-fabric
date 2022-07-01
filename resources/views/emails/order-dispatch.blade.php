@extends('layouts.email')

@section('content')
<style>
    @media screen and (max-width: 525px) {
        body {
            width: 100% !important;
        }
    }
</style>

<table align="center" border="0" cellpadding="5" cellspacing="0" style="width: 100%; font-family: Arial; max-width: 1200px;">
    <tbody>
        <tr>
            <td>
                <p style="color: #484848; font-family: Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; line-height: 18px; margin: 20px; padding: 0;">
                    Hello {{ $order->user->getFullName() }}
                    <br /><br />
                    Great news! Your order #{{ $order->friendly_id }} is packed and ready to go!
                    <br /><br />
                    We always love to see what you get up to with your Fashion Formula goodies, so be sure to show us by tagging <a href="{{ getSettingValue('social_media/instagram_link') }}" target="_blank">@fashionformulauk</a> and #fashionformulauk in your Instagram pics.
                    <br /><br />
                    We often feature designers and offer prizes to great designs and inspiring uses of our fabrics and papers. It never ceases to amaze us what a clever and creative bunch you all are!
                    <br /><br />
                    Your item(s) is (are) being sent by {{ $order->shippingAddress->branding->title }}. 
		    <br /><br />
		     Your tracking number is {{ $order->tracking_number }}. You can also find your tracking number by logging into your account.
		    <br /><br />
			To track by Royal Mail - <a href="https://www3.royalmail.com/track-your-item#/">Royal Mail</a>		
		    <br /><br />
			To track by APC Courier - <a href="https://apc-overnight.com/receiving-a-parcel/tracking">APC Couriers</a>
 		    <br /><br />
		     Depending on the delivery method you chose, it's possible that the tracking information might not be visible immediately. To find out more about Tracking, please visit our <a href="{{ route('view.faqs') }}" target="_blank">FAQs page</a>.
                </p>
            </td>
        </tr>
    </tbody>
</table>

@stop

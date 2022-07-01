@extends('layouts.email')

@section('content')

<table align="center" border="0" cellpadding="5" cellspacing="0" width="600" style="border-collapse: collapse; font-family: Arial;">
    <tbody>
        <tr>
            <td>
                <p style="color: #484848; font-family: Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 15px; line-height: 25px; margin: 20px; padding: 0;">
                    <center>
                        Congratulations, someone has just bought your design on our products.
                        <br /><br />
                        Design Number: #{{ $sale->orderItem->design->friendly_id }}<br />
                        Design Title: {{ $sale->orderItem->design->title }}<br />
                        Commission Owed: &pound;{{ formatPrice($sale->amount) }}<br />
                        <br /><br />
                        As long as the order is not cancelled, you should expect the payment around the date below:
                        <br /><br />
                        Estimated Commission Payable date: {{ date('d-m-Y', strtotime('next month')) }}
                        <br /><br />
                        We will notify you when the payment is made. You can also see the commission status at <a style="color:#21ded5;text-decoration:none;" href="{{ route('view.orders') }}" target="_blank">{{ route('view.orders') }}</a>
                        <br /><br />
                        Please ensure that your payment details are up-to-date to avoid delays in payment or wrongly routed payments. You can alter these at <a style="color:#21ded5;text-decoration:none;" href="{{ route('view.user.account') }}" target="_blank">{{ route('view.user.account') }}</a>
                        <br /><br />
                        To find out more about our commission system or to find out how to promote your designs to get more commissions, please visit our <a style="color:#21ded5;text-decoration:none;" href="{{ route('view.faqs') }}" target="_blank">FAQs page</a>
                        <br /><br />
                        All the best....the Fashion Formula team
                    </center>
                </p>
            </td>
        </tr>
    </tbody>
</table>

@stop

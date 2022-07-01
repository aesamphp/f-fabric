@extends('layouts.email')

@section('content')

<table align="center" border="0" cellpadding="5" cellspacing="0" width="600" style="border-collapse: collapse; font-family: Arial;">
    <tbody>
        <tr>
            <td>
                <p style="color: #484848; font-family: Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; line-height: 18px; margin: 20px; padding: 0;">
                    Like Jerry Maguire, we are showing you the money!
                    <br /><br />
                    Your nominated account has now been credited with the below amount:
                    <br /><br />
                    Gross Amount: &pound;{{ $commission->amount }}<br />
                    Tax Amount: &pound;{{ $commission->tax }}<br />
                    Net Amount: &pound;{{ $commission->getTotalAmount() }}
                    <br /><br />
                    If you have any problems receiving your commission, please contact us at <a href="mailto:info@fashion-formula.com">info@fashion-formula.com</a>
                    <br /><br />
                    To find out more about our commission system, please visit our <a href="{{ route('view.faqs') }}" target="_blank">FAQs page</a>
                    <br /><br />
                    All the best....the Fashion Formula team
                </p>
            </td>
        </tr>
    </tbody>
</table>

@stop

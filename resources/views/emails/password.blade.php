@extends('layouts.email')

@section('content')

<style>
    @media screen and (max-width: 525px) {
        body {
            width: 100% !important;
        }
    }
</style>    

<table align="center" border="0" cellpadding="5" cellspacing="0" width="100%" style="border-collapse: collapse; font-family: Arial;">
    <tbody>
        <tr>
            <td>
                <p style="color: #484848; font-family: Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; line-height: 18px; margin: 20px; padding: 0;">
                    <center>
                        Whoops...looks like you forgot your password. Don't worry, it happens to the best of us....
                        <br /><br />
                        However, like your knight in shining armour, we are here to help you. Yay!
                        <br /><br />
                        Please find a link below that will help you reset your password.
                        <br /><br />

                        <a href="{{ route(empty($adminResetPassword)
                            ? 'view.reset.password'
                            : 'admin::auth.reset-password.index', [
                                'token' => $token,
                            ]) }}"
                            target="_blank"
                        >
                            Click Here
                        </a>
                        <br /><br />
                        Hope to see you soon....the Fashion Formula team
                    </center>
                </p>
            </td>
        </tr>
    </tbody>
</table>

@stop

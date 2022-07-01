@extends('layouts.email')

@section('content')
<center>
    <img style="width:100%;" src="{{ asset('images/email-congrats-screen.png') }}" alt="Congratulations! You Have Taken The First Step to Creating Your Own Masterpiece" />
</center>

<table align="center" border="0" cellpadding="5" cellspacing="0" width="600" style="border-collapse: collapse; font-family: Arial;">
    <tbody>
        <tr>
            <td>
                <center>
                    <p style="color: #484848; font-family: Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 15px; line-height: 25px; margin: 20px; padding: 0;">
                        Dear <span style="color:#21ded5;text-decoration:none;">{{ $user->getFullName() }}</span>
                        <br /><br />
                        Please find your account details below:
                        <br /><br />
                        Name: {{ $user->getFullName() }}<br />
                        Email Address: {{ $user->email }}<br />
                        Username: {{ $user->username }}<br />
                        <br /><br />
                        Keep these safe, as like the door to Narnia, they will provide you access to a cornucopia of wonderful patterns, helpful design tips and a growing community of designer - makers.
                        <br /><br />
			You might like to get started by seeing our full range of over 100 fabrics and papers that we print upon. You can order our sample book online by clicking here - <a href="https://www.fashion-formula.com/shop/sample-books/">Sample Books</a>	
			<br /><br />                      
  			All the best....the Fashion Formula team
                    </p>
                </center>
            </td>
        </tr>
    </tbody>
</table>

@stop

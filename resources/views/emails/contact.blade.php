@extends('layouts.email')

@section('content')

    <div style="padding-top:20px;padding-bottom:20px;">
        <table align="center" border="0" cellpadding="5" cellspacing="0" width="600" style="border-collapse: collapse; font-family: Arial;">
            <tbody>
                <tr>
                    <td>
                        <center>
                            <p style="color: #484848; font-family: Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 15px; line-height: 25px; margin: 20px; padding: 0;">
                                Dear <span style="color:#21ded5;text-decoration:none;">{{ $enquiry->name }}</span><br /><br />
                                Thank you for contacting Fashion Formula, your on-demand digital textile and wallpaper printing company.
                                <br /><br />
                                During opening hours, we will try and come back to you within 2 hours.
                                <br /><br />
                                While you are waiting, try our 'create your own' fabric and wallpaper tool or choose from one of the many designs created by our independent design community.
                                <br /><br />
                                If you are feeling more adventurous, you can participate in our design community, vote on the best design in the weekly contest or upload your own designs to sell for commission.
                                <br /><br />
                                Chat soon...... the Fashion Formula team
                            </p>
                        </center>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

@stop

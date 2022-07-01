@extends('layouts.email')

@section('content')

<table align="center" border="0" cellpadding="5" cellspacing="0" width="600" style="border-collapse: collapse; font-family: Arial;">
    <tbody>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td style="width:150px;">Name:</td>
            <td>{{ $enquiry->name }}</td>
        </tr>
        <tr>
            <td>Email Address:</td>
            <td>{{ $enquiry->email }}</td>
        </tr>
        @if ($enquiry->phone)
        <tr>
            <td>Phone Number:</td>
            <td>{{ $enquiry->phone }}</td>
        </tr>
        @endif
        <tr>
            <td>Subject:</td>
            <td>{{ $enquiry->subject }}</td>
        </tr>
        <tr>
            <td style="vertical-align: top;">Message:</td>
            <td>{{ $enquiry->message }}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>        
    </tbody>
</table>

@stop

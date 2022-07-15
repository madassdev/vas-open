@extends('email.layout')
@section('content')
<h3>
    You requested for a password reset token.
    <h3>
        <p style="padding-top: 20px; font-size:12px">Here's the token.</p>
        <p>
            Token: <b>{{$user->verification_code}}</b>
        </p>
        <p style="padding-top: 20px; font-size:12px">You can now reset your password with this token.</p>
        @endsection
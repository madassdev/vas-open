@extends('email.layout')
@section('content')
<p>
    Hello, <b>{{$user->email}}</b>
</p>
<p>
    You requested for a password reset.
<p>
<p style="padding-top: 20px; font-size:12px">Click on the link below to reset password.</p>
<p>
    <a href="{{ makePasswordLink($user->verification_code, $user->url) }}" style="display:inline-flex; 
                text-align:center; 
                padding:8px; 
                border-radius:5px;
                background:#ff8000;
                color:white;" target="_blank" rel="noopener">Reset Password</a>
</p>
<!-- <p style="padding-top: 20px; font-size:12px">You can now reset your password with this token.</p> -->
@endsection
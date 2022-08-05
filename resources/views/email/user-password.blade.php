@extends('email.layout')
@section('content')
<p>
    Hello, <b>{{$user->email}}</b>
</p>
<p>
    Welcome to Vas Reseller.
    Your account has been created with the following details:
</p>
<p>
    Email: <b>{{$user->email}}</b>
</p>
<p>
    Password: <b>{{$user->verification_code}}</b>
</p>
<p style="padding-top: 20px; font-size:12px">You can now login to your dashboard with these details</p>
@endsection
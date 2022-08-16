@extends('email.layout')
@section('content')
<p>
    Hello, <b>{{ucfirst($user->first_name)}}</b>
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
<p style="padding-top: 20px;">You can now login to your dashboard with these details</p>
@endsection
@extends('email.layout')
@section('content')
<p>
    Hello, <b>{{ucfirst($payload['user']->first_name)}}</b>
</p>
<p>
    Your administrator account has been created with the following details:
</p>
<p>
    Email: <b>{{$payload['user']->email}}</b>
</p>
<p>
    Password: <b>{{$payload['password']}}</b>
</p>
<p>
    Role: <b>{{strtoupper($payload['role']->title ?? $payload['role']->name)}}</b>
</p>
<p style="padding-top: 20px;">You can now login to your dashboard with these details</p>
@endsection
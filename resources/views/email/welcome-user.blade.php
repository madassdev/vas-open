@extends('email.layout')
@section('content')
<p>
    Hello, <b>{{ucfirst($user->first_name)}}</b>
</p>
<h1>
    Welcome to Vas Reseller
</h1>
<p>
    Here's your email: <b>{{$user->email}}</b>
</p>
@endsection
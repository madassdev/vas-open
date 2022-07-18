@extends('email.layout')
@section('content')
<h1>
    Welcome to Vas Reseller
</h1>
<p>
    Here's your email: <b>{{$user->email}}</b>
</p>
@endsection
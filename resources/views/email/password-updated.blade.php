@extends('email.layout')
@section('content')
<h3>
YOUR EXISTING PASSWORD HAS BEEN UPDATED, SECURE YOUR ACCOUNT...
</h3>
<p>
    Email: <b>{{$user->email}}</b>
</p>
@endsection
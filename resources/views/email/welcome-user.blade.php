@extends('email.layout')
@section('content')
<h1>
    WELCOME TO THE APP
</h1>
<p>
    email: <b>{{$user->email}}</b>
</p>
@endsection
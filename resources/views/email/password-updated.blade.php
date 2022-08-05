@extends('email.layout')
@section('content')
<p>
    Hello, <b>{{$user->email}}</b>
</p>
<h3>
    Your password has been updated successfully
</h3>
@endsection
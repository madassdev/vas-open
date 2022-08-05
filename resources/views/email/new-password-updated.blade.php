@extends('email.layout')
@section('content')
<p>
    Hello, <b>{{$user->email}}</b>
</p>
<p>
    Your password has been updated and your account verified on Vas Reseller.
</p>
@endsection
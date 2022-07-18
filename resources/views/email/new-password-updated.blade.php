@extends('email.layout')
@section('content')
<h3>
    Your password has been updated and your account verified on Vas Reseller.
</h3>
<p>
    Email: <b>{{$user->email}}</b>
</p>@endsection
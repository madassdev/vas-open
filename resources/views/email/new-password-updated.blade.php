@extends('email.layout')
@section('content')
<p>
    Hello, <b>{{ucfirst($user->first_name)}}</b>
</p>
<p>
    Your password has been updated and your account verified on Vas Reseller.
</p>
@endsection
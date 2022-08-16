@extends('email.layout')
@section('content')
<p>
    Hello, <b>{{ucfirst($user->first_name)}}</b>
</p>
<h3>
    Your password has been updated successfully
</h3>
@endsection
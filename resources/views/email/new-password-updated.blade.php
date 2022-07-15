@extends('email.layout')
@section('content')
<h3>
    Your password has been updated. You can now use the app.
</h3>
<p>
    Email: <b>{{$user->email}}</b>
</p>@endsection
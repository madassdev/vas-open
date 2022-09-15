@extends('email.layout')
@section('content')
<p>Hello, {{$payload["business"]->email}}</p>
<p>
   Your Business Document verification request was not successful.
</p>
<p>
    <strong>Comment: </strong> {{$payload["document_request"]->comment}}
</p>
        <!-- <p style="padding-top: 20px; font-size:12px">You can now work together on this business.</p> -->
        @endsection
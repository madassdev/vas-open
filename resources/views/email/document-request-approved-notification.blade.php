@extends('email.layout')
@section('content')
<p>Hello, {{$payload["business"]->email}}</p>
<p>
   Your Business Documents have been reviewed and approved on Vasreseller.
</p>
        <!-- <p style="padding-top: 20px; font-size:12px">You can now work together on this business.</p> -->
        @endsection
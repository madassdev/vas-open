@component('mail::message')
<h3>
YOUR EXISTING PASSWORD HAS BEEN UPDATED, SECURE YOUR ACCOUNT...
</h3>
<p>
    Email: <b>{{$user->email}}</b>
</p>
@include('email.unified-template')
@endcomponent
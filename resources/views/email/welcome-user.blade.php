@component('mail::message')
<h1>
    WELCOME TO THE APP
</h1>
<p>
    email: <b>{{$user->email}}</b>
</p>
@include('email.unified-template')
@endcomponent

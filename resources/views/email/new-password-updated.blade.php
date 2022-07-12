@component('mail::message')
<h3>
    Your password has been updated. You can now use the app.
</h3>
<p>
    Email: <b>{{$user->email}}</b>
</p>
@include('email.unified-template')
@endcomponent
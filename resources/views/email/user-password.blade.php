@component('mail::message')
<h3>
    Your account has been created with the following details:
    <h3>
        <p>
            Email: <b>{{$user->email}}</b>
        </p>
        <p>
            Password: <b>{{$user->verification_code}}</b>
        </p>
        <p style="padding-top: 20px; font-size:12px">You can now login to your dashboard with these details</p>
        @endcomponent
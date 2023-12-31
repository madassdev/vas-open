@extends('email.layout')
@section('content')
<p>Hello, {{$payload["invitee"]->email}}</p>
<p>
    You have been invited by {{$payload["inviter"]->email}} to collaborate on
    {{$payload["business"]->name}}
</p>
        <p style="padding-top: 20px;">Click on the link below to accept invitation.</p>
        <p>
            <a href="{{ makeInviteLink($payload['invitee'], $payload['url']) }}" style="display:inline-flex; 
                text-align:center; 
                padding:8px; 
                border-radius:5px;
                background:#ff8000;
                color:white;" target="_blank" rel="noopener">Accept Invite</a>
        </p>
        <!-- <p style="padding-top: 20px; font-size:12px">You can now work together on this business.</p> -->
        @endsection
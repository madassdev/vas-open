@component('mail::message')
<h3>
    You have been invited by {{$payload["inviter"]->email}} to collaborate on
    {{$payload["business"]->name}}
    <h3>
        <p style="padding-top: 20px; font-size:12px">Click on the link below.</p>
        <p>
            <a href="{{ makeInviteLink($payload['invitee'], $payload['url']) }}" style="text-align:center" class="button button-{{ $color ?? 'primary' }}" target="_blank" rel="noopener">Accept Invite</a>
        </p>
        @include('email.unified-template')
        @endcomponent
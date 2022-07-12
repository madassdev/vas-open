<?php

use App\Models\User;

function generateFrontendLink($param, $value, $path = '')
{
    $frontendDomain = env("APP_FRONTEND_DOMAIN", "http://localhost");
    return $frontendDomain . $path . "?$param=$value";
}

function makeInviteLink($invitee)
{
    $frontendDomain = env("APP_FRONTEND_DOMAIN", "http://localhost");
    $path = "/mail/invitations";
    $invitation_token = encrypt($invitee->code);
    $email = $invitee->email;
    $userExists = User::whereEmail($email)->first() ? 1 : 0;
    $link = $frontendDomain . $path . "?invitation_token=$invitation_token&email=$email&userExists=$userExists";
    return $link;
}

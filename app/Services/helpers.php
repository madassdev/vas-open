<?php

use App\Models\User;

function generateFrontendLink($param, $value, $path = '')
{
    $frontendDomain = env("APP_FRONTEND_DOMAIN", "http://localhost");
    return $frontendDomain . $path . "?$param=$value";
}

function makeInviteLink($invitee, $url=null)
{
    // Prepare payload in query string
    $invitation_token = encrypt($invitee->code);
    $email = $invitee->email;
    $userExists = User::whereEmail($email)->first() ? 1 : 0;
    $queryString = "?invitation_token=$invitation_token&email=$email&userExists=$userExists";
    
    // Prepare frontend url
    $frontendDomain = env("APP_FRONTEND_DOMAIN", "http://localhost");
    $path = "auth/accept-invite";
    $backend_link = $frontendDomain . $path;
    return $url ? $url.$queryString : $backend_link.$queryString;
}

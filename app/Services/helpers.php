<?php

use App\Models\User;

function generateFrontendLink($param, $value, $path = '')
{
    $frontendDomain = env("APP_FRONTEND_DOMAIN", "http://localhost");
    return $frontendDomain . $path . "?$param=$value";
}

function makeInviteLink($invitee, $url = null)
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
    return $url ? $url . $queryString : $backend_link . $queryString;
}

function bankCodes()
{
    return [
        "044" =>    "Access Bank Nigeria Plc",
        "063" =>    "Diamond Bank Plc",
        "050" =>    "Ecobank Nigeria",
        "084" =>    "Enterprise Bank Plc",
        "070" =>    "Fidelity Bank Plc",
        "011" =>    "First Bank of Nigeria Plc",
        "214" =>    "First City Monument Bank",
        "058" =>    "Guaranty Trust Bank Plc",
        "030" =>    "Heritaage Banking Company Ltd",
        "301" =>    "Jaiz Bank",
        "082" =>    "Keystone Bank Ltd",
        "014" =>    "Mainstreet Bank Plc",
        "076" =>    "Skye Bank Plc",
        "039" =>    "Stanbic IBTC Plc",
        "232" =>    "Sterling Bank Plc",
        "032" =>    "Union Bank Nigeria Plc",
        "033" =>    "United Bank for Africa Plc",
        "215" =>    "Unity Bank Plc",
        "035" =>    "WEMA Bank Plc",
        "057" =>    "Zenith Bank International",
    ];
}

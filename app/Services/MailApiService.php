<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MailApiService
{
    private $recipient;
    private $subject;
    private $content;
    private $url = "http://196.46.20.56:8096/api/Payarena/email";

    public function __construct($recipient, $subject, $content)
    {
        //
        $this->recipient = $recipient;
        $this->subject = $subject;
        $this->content = $content;
    }

    public function build()
    {
        return [
            "Address" => $this->recipient,
            "Message" => $this->content,
            "Subject" => $this->subject
        ];
    }

    public function send()
    {
        $payload = $this->build();
        return Http::timeout(50)->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($this->url, $payload)->json();
    }
}

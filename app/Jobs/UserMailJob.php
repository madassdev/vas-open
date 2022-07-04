<?php

namespace App\Jobs;

use App\Mail\UserCreatedPasswordMail;
use App\Mail\UserWelcomeMail;
use App\Services\MailApiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UserMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $user;
    public function __construct($user)
    {
        //
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        // $welcomeMail = new MailApiService($this->user->email, '[Vas Reseller] Welcome aboard!', (new UserWelcomeMail($this->user))->render());
        // $welcomeMail->send();
        $passwordMail = new MailApiService($this->user->email, "[Vas Reseller] Here's your password!", (new UserCreatedPasswordMail($this->user))->render());
        $passwordMail->send();
    }
}

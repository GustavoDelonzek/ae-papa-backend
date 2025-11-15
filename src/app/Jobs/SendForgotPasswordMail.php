<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Mail;

class SendForgotPasswordMail implements ShouldQueue
{
    use Queueable;

    public function __construct(private string $email, private string $token)
    {
    }

    public function handle(): void
    {
        Mail::to($this->email)->send(new ForgotPasswordMail($this->token, $this->email));
    }
}

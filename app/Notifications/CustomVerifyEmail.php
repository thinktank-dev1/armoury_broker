<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

use App\Lib\Communication;

class CustomVerifyEmail
{
    public $id;
    public function via($notifiable){
        return ['custom'];
    }

    protected function verificationUrl($notifiable){
        $temporarySignedUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );

        return $temporarySignedUrl;
    }

    public function toMail($notifiable){
        $this->id = $notifiable->id;

        $verificationUrl = $this->verificationUrl($notifiable);

        $after ="Should you not have created an account, or created an account error, you can discard this email.<br /><br />
        If you're having trouble clicking the \"Verify Email Address\" button, copy and paste the URL below into your web browser: <br /><br />
        ".$verificationUrl;

        $data = [
            'to' => $notifiable->email,
            'name' => $notifiable->name,
            'subject' => 'Verify Email Address',
            'title' => "Verify your details",
            'message_body' => "Please click on the button below to verify your email address and gain access to South Africa's premier secure marketplace for armoury equipment.",
            'cta' => true,
            'cta_text' => 'verify Email',
            'cta_url' => $verificationUrl,
            'after_cta_body' => $after,
        ];
        // $comm = new Communication();
        // $comm->sendMail($data);
        return $data;
    }
}

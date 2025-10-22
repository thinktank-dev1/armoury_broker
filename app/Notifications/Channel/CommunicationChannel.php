<?php

namespace App\Notifications\Channel;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommunicationChannel extends Notification
{
    public function send($notifiable, $notification){
        $data = $notification->toMail($notifiable);

        $comm = new \App\Lib\Communication();
        $comm->sendMail($data);
    }
}

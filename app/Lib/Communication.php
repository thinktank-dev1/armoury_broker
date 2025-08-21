<?php

namespace App\Lib;

use Mail;

class Communication
{
    public function sendMail($data){
        $to = $data['to'];
        $subject = $data['subject'];
        $mail = Mail::send('mail.comm', $data, function($message) use($to,$subject){
            $message->to($to, '')->subject($subject);
        });
    }
}

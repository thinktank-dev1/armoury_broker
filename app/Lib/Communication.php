<?php

namespace App\Lib;
use Illuminate\Support\Facades\Crypt;

use Mail;
use App\Models\User;

class Communication
{
    public function sendMail($data){
        $payload = [];
        $usr = User::where('email', $data['to'])->first();
        if($usr){
            $payload = [
                'id' => $usr->id,
                'email' => $usr->email,
                'iat' => time(),
            ];
        }
        $encrypted = Crypt::encryptString(json_encode($payload));
        $token = $this->base64url_encode($encrypted);
        $unsubscribe_link = url("/unsubscribe/{$token}");

        $data['unsubscribe_link'] = $unsubscribe_link;

        $to = $data['to'];
        $subject = $data['subject'];
        $mail = Mail::send('mail.comm', $data, function($message) use($to,$subject){
            $message->to($to, '')->subject($subject);
        });
    }

    public function base64url_encode(string $data): string {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public function base64url_decode(string $data): string {
        $remainder = strlen($data) % 4;
        if ($remainder) $data .= str_repeat('=', 4 - $remainder);
        return base64_decode(strtr($data, '-_', '+/'));
    }
}

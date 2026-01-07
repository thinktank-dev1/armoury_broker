<?php

namespace App\Http\Controllers;

use Request;

use App\Models\User;
use App\Models\DeleteConfirmation;
use Illuminate\Support\Str;

class FbController extends Controller
{
    public function delete(){
        if(Request::has('signed_request')){
            $signed_request = Request::input('signed_request');
            $data = $this->parse_signed_request($signed_request);
            $user_id = $data['user_id'];

            $usr = User::where('facebook_id', $user_id)->first();
            if($usr){
                $token = Str::random(5).'-'.$usr->id.'-'.date('Ymd');
                $del = DeleteConfirmation::create([
                    'token' => $token,
                    'user_id' => $usr->id,
                ]);
                $usr->delete();

                $status_url = url('/fb-status/'.$token);

                $data = [
                    'url' => $status_url,
                    'confirmation_code' => $token
                ];
                echo json_encode($data);
            }
        }
    }

    public function parse_signed_request($signed_request) {
        list($encoded_sig, $payload) = explode('.', $signed_request, 2);

        $secret = env('FACEBOOK_CLIENT_SECRET');

        $sig = $this->base64_url_decode($encoded_sig);
        $data = json_decode($this->base64_url_decode($payload), true);

        $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
        if ($sig !== $expected_sig) {
            error_log('Bad Signed JSON signature!');
            return null;
        }
        return $data;
    }

    public function base64_url_decode($input) {
        return base64_decode(strtr($input, '-_', '+/'));
    }
}

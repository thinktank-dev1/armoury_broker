<?php

namespace App\Lib;

class PayFastApi{
    
    public function setPayLoad($data){
        $details = [
            'merchant_id' => env('PAYFAST_MERCHANT_ID'),
            'merchant_key' => env('PAYFAST_MERCHANT_KEY'),
            'return_url' => url('/pf-payment/'.$data['payment_id'].'/pending'),
            'cancel_url' => url('/pf-payment/'.$data['payment_id'].'/canceled'),
            'notify_url' => url('/pf-notify-payment/'.$data['payment_id']),
            'name_first' => $data['user_first_name'],
            'name_last' => $data['user_last_name'],
            'email_address' => $data['user_email'],
            'm_payment_id' => "AB".$data['payment_id'],
            'amount' => number_format( sprintf( '%.2f', $data['amount'] ), 2, '.', '' ),
            'item_name' => "Armoury Broker Purchase",
            'item_description' => 'Armoury Broker',
            'email_confirmation' => '1',
            'confirmation_address' => env('PAYFAST_CONFIRMATION_EMAIL'),  
        ];
        $sig_data = null;
        foreach($details AS $key => $val){
            if($val){
                $sig_data .= $key.'='.urlencode(trim($val)).'&';
            }
        }
        
        $sig_data = substr($sig_data, 0, -1);
        if(env('PAYFAST_SALT') != ''){
            $sig_data .= '&passphrase='. urlencode(trim(env('PAYFAST_SALT')));
        }
        $sig = md5($sig_data);
        $details['signature'] = $sig;
        return $details;
    } 
}

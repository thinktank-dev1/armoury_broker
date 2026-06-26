<?php
namespace App\Lib;

use Log;

class WalletDocApi{
	public function genPayment($data){
		$privateApiKey = env('WALLET_DOC_PVT');

		$ch = curl_init();

		curl_setopt_array($ch, [
    		CURLOPT_URL => "https://www.walletdoc.com/v1/transactions/checkout",
    		CURLOPT_RETURNTRANSFER => true,
    		CURLOPT_POST => true,
    		CURLOPT_HTTPHEADER => [
        		"Authorization: Basic {$privateApiKey}",
        		"Content-Type: application/json"
    		],
    		CURLOPT_POSTFIELDS => json_encode($data)
		]);

		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close($ch);

		if ($httpCode >= 200 && $httpCode < 300) {
    		$transaction = json_decode($response, true);
    		return $transaction;
		} 
		else {
			dd($response,$data);
    		Log::error($response);
    		return false;
		}
	}
}
?>
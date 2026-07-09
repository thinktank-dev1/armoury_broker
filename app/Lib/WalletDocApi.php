<?php
namespace App\Lib;

use Log;

class WalletDocApi{
	public function processTransaction($trx_id,$data){
		$privateApiKey = env('WALLET_DOC_PVT');
		$url = 'https://www.walletdoc.com/v1/transactions/'.$trx_id.'/process';

		$ch = curl_init();
		curl_setopt_array($ch, [
    		CURLOPT_URL => $url,
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
    		Log::error($response);
    		return false;
		}

	}

	public function createCustomer($data){
		$privateApiKey = env('WALLET_DOC_PVT');
		$url = 'https://www.walletdoc.com/v1/customers';

		$ch = curl_init();
		curl_setopt_array($ch, [
    		CURLOPT_URL => $url,
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
    		Log::error($response);
    		return false;
		}


	}

	public function genPayment($data){
		$privateApiKey = env('WALLET_DOC_PVT');

		// $url = "https://www.walletdoc.com/v1/transactions";
		$url = "https://www.walletdoc.com/v1/transactions/checkout";

		$ch = curl_init();
		curl_setopt_array($ch, [
    		CURLOPT_URL => $url,
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
    		Log::error($response);
    		return false;
		}
	}

	public function checkPayment($id){
		$privateApiKey = env('WALLET_DOC_PVT');

		$ch = curl_init();

		curl_setopt_array($ch, [
    		CURLOPT_URL => "https://www.walletdoc.com/v1/transactions/".$id,
    		CURLOPT_RETURNTRANSFER => true,
    		CURLOPT_HTTPHEADER => [
        		"Authorization: Basic {$privateApiKey}",
        		"Content-Type: application/json"
    		]
		]);

		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close($ch);

		if ($httpCode >= 200 && $httpCode < 300) {
    		$transaction = json_decode($response, true);
    		return $transaction;
		} 
		else {
    		Log::error($response);
    		return false;
		}
	}
}
?>
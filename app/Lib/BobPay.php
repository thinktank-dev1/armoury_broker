<?php
namespace App\Lib;

class BobPay{
	protected $token;

	function __construct(){
		if(!$this->token){
			$this->auth();
		}
	}

	public function auth(){
		$user_name = env('BOB_PAY_EMAIL');
		$pass = env('BOB_PAY_PASSPHRASE');

		$url = env('BOB_PAY_URL').'/login';

		$payload = [
			'email' => $user_name,
			'password' => $pass
		];

		$res = $this->runPostCurlNoHeaders($url,$payload);
		if($res){
			if(isset($res['access_token'])){
				$this->token = $res['access_token'];
			}
		}
	}

	public function genSignature($payload){
		if($this->token){
			$url = env('BOB_PAY_URL').'/v2/payments/intents/signature/generate';
			$res = $this->runPostCurl($url, $payload);
		}
	}

	public function runPostCurl($url, $payload){
		$payload = json_encode($payload);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			"Authorization: Bearer ".$this->token,
			"Content-Type: application/json",
			"Content-Length: " . strlen($payload)
		]);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);

		$response = curl_exec($ch);
		curl_close($ch);

		dd(curl_getinfo($ch),$response);

		$res = json_decode($response, true);
		return $res;
	}

	public function runPostCurlNoHeaders($url,$payload){
		$payload = json_encode($payload);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
    		"Content-Type: application/json",
    		"Content-Length: " . strlen($payload)
		]);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$response = curl_exec($ch);
		curl_close($ch);

		$res = json_decode($response,true);
		return $res;
	}
}
?>
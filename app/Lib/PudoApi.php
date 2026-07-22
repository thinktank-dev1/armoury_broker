<?php
namespace App\Lib;

use Log;

class PudoApi{
	function getTerminals(){
		$api_key = env('PUDO_API_KEY');
		// $url = "https://wqvdmjybt6.execute-api.af-south-1.amazonaws.com/lockers-data";
		$url = env('PUDO_URL').'/lockers-data';

		$ch = curl_init();

		curl_setopt_array($ch, [
    		CURLOPT_URL => $url,
    		CURLOPT_RETURNTRANSFER => true,
    		CURLOPT_HTTPHEADER => [
        		"Authorization: Bearer {$api_key}",
        		"Content-Type: application/json",
        		"ACCEPT: application/json"
    		]
		]);

		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$response = json_decode($response,true);
		
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if ($httpCode >= 200 && $httpCode < 300) {
			return $response;
		}
		return false;
	}

	function getRate($col,$del,$coll_add, $del_add, $parcels){
		if($col == "door" && $del == "door"){
			$data = [
				'collection_address' => $coll_add,
				'delivery_address' => $del_add,
				'parcels' => [$parcels],
			];
		}
		else{
			$data = [
				'collection_address' => $coll_add,
				'delivery_address' => $del_add,
			];
		}

		$api_key = env('PUDO_API_KEY');
		$url = env('PUDO_URL').'/rates';

		$ch = curl_init();

		curl_setopt_array($ch, [
    		CURLOPT_URL => $url,
    		CURLOPT_RETURNTRANSFER => true,
    		CURLOPT_POST => true,
    		CURLOPT_HTTPHEADER => [
        		"Authorization: Bearer {$api_key}",
        		"Content-Type: application/json",
        		"ACCEPT: application/json"
    		],
    		CURLOPT_POSTFIELDS => json_encode($data)
		]);

		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close($ch);

		if ($httpCode >= 200 && $httpCode < 300) {
    		$rates = json_decode($response, true);
    		if($col == "door" && $del == "door"){
    			return $rates["rates"][0];
    		}

    		if($col == "door" && $del == "locker"){
	    		$package = [$parcels['submitted_length_cm'], $parcels['submitted_width_cm'], $parcels['submitted_height_cm']];
	    		sort($package);

	    		foreach($rates['rates'] AS $rate){
	    			$sv = $rate['service_level'];
	    			$dm = $sv['dimensions'];
	    			$dm_arr = [$dm['width'], $dm['height'],$dm['length']];
	    			sort($dm_arr);
	    			if(
	    				(int)$dm_arr[0] >= (int)$package[0] &&
	    				(int)$dm_arr[1] >= (int)$package[1] &&
	    				(int)$dm_arr[2] >= (int)$package[2] &&
	    				(int)$dm['weight'] >= (int)$parcels['submitted_weight_kg']
	    			){
	    				return $rate;
	    			}
	    		}
    		}
    		return [
    			"status" => "error",
    			"message" => "Failed to find candidate rate",
    		];
    		
		} 
		else {
			$res = json_decode($response, true);
    		Log::error($res);
    		return ['error' => $res["message"]];
		}
	}

	public function createShipment($col,$del,$coll_add, $del_add, $parcels,$vendor_detail,$buyer_details){
		$data = [
			'collection_min_date' => date('Y-m-d', strtotime('+3 days')),
			'collection_address' => $coll_add,
			'special_instructions_collection' => 'None',
			'collection_contact' => $vendor_detail,
			'delivery_min_date' => date('Y-m-d', strtotime('+5 days')),
			'delivery_address' => $del_add,
			'delivery_contact' => $buyer_details,
			'parcels' => [$parcels],
			'opt_in_rates' => [],
			'opt_in_time_based_rates' => [],
			'service_level_code' => 'OVN',
		];

		$api_key = env('PUDO_API_KEY');
		$url = env('PUDO_URL').'/shipments';

		$ch = curl_init();

		curl_setopt_array($ch, [
    		CURLOPT_URL => $url,
    		CURLOPT_RETURNTRANSFER => true,
    		CURLOPT_POST => true,
    		CURLOPT_HTTPHEADER => [
        		"Authorization: Bearer {$api_key}",
        		"Content-Type: application/json",
        		"ACCEPT: application/json"
    		],
    		CURLOPT_POSTFIELDS => json_encode($data)
		]);

		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close($ch);

		if ($httpCode >= 200 && $httpCode < 300) {
    		$result = json_decode($response, true);
    		return $result;
    	}
    	return false;
	}
}
?>
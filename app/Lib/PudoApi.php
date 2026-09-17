<?php
namespace App\Lib;

use Log;
use stdClass;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

use Pudo\Common\Processor\APIProcessor;

class PudoApi{
	public $apiURL;
	public $accountKey;
	public $lockers;

	function __construct(){
		$this->apiURL = 'https://sandbox.api-pudo.co.za';
		$this->accountKey = env('PUDO_API_KEY');
		$this->lockers = $this->getAllLockers();
	}

	public function getRates(array $data){
		$requestBody = new stdClass();

        $requestBody->collection_address = $this->buildCollectionAddress($data['collection'],$data['method']);
        $requestBody->delivery_address   = $this->buildDeliveryAddress($data['delivery'],$data['method']);
        $requestBody->parcels = $data['parcels'];
        
		$response = $this->callPudoApi( 'get_rates', json_encode($requestBody));
		// dd($response->body(),$requestBody,$this->lockers[$data["delivery"]["terminal_id"]]);
		if ($response->successful()){
			$body = $response->json();
			if(isset($body['success'])){
				if($body['success'] == false){
					return $body['message'];
				}
			}
			$pc_data = [
				$data['parcels'][0]['submitted_width_cm'],
				$data['parcels'][0]['submitted_length_cm'],
				$data['parcels'][0]['submitted_height_cm'],
			];
			sort($pc_data);
			if(isset($body['rates'])){
				foreach($body['rates'] AS $k => $res){
					$rt_dim = [
						$res['service_level']['dimensions']['width'],
						$res['service_level']['dimensions']['height'],
						$res['service_level']['dimensions']['length'],
					];
					sort($rt_dim);
					if($rt_dim == $pc_data){
						$ret = [
							"status" => "success",
							"rate" => $res,
						];
						return $ret;
					}
				}
			}
		}
		else{
			$res = $response->json();
			return $res["message"];
		}
		return false;
	}

	public function getAllLockers(): array
	{
		$cacheKey = "pudo_lockers_{$this->apiURL}";
		$mappedLockers = Cache::get($cacheKey);
		if (!$mappedLockers) {
			$response = $this->callPudoApi('get_all_lockers');
			if ($response->successful()){
				$body = $response->body();
				try {
					if (!is_string($body)) {
						Log::error('getAllLockers: Response body is not a string.', ['type' => gettype($body),]);
						return [];
					}
					json_decode($body, true, 512, JSON_THROW_ON_ERROR);
					$mappedLockers = APIProcessor::mapLockers($body);
					$compressed = base64_encode(
						gzcompress(serialize($mappedLockers))
					);
					Cache::put($cacheKey, $compressed, now()->addDay());
				} 
				catch (\JsonException $e) {
					Log::error('getAllLockers: JSON decode failed.', ['error' => $e->getMessage(),]);
					return [];
				}
			} 
			else {
				return [];
			}
		}
		if (!is_array($mappedLockers)){
			$mappedLockers = unserialize(
				gzuncompress(base64_decode($mappedLockers))
			);
		}
		return $mappedLockers;
	}

	private function callPudoApi(string $method, mixed $content = null): Response
	{
	    $apiProcessor = new APIProcessor($this->apiURL);
	    $request = $apiProcessor->getRequest($method, $content);

	    $http = Http::withToken($this->accountKey)
	    ->timeout(30)
	    ->acceptJson();

	    if ($request['type'] === 'POST') {
	        $http = $http->contentType('application/json');
	    }

	    return match ($request['type']) {
	        'GET' => $http->get($request['url']),
	        'POST' => $http->withBody($content, 'application/json')
	                       ->post($request['url']),
	        default => throw new \InvalidArgumentException(
	            "Unsupported request type [{$request['type']}]"
	        ),
	    };
	}

	private function buildCollectionAddress($data,$method): stdClass
    {
        $collectionAddress = new stdClass();
        if ($method === 'L2L' || $method === 'L2D') {
            $collectionAddress->terminal_id = $data['terminal_id'];
        } else {
            $collectionAddress->type            = $data['type'];
            $collectionAddress->street_address  = $data['street'];
            $collectionAddress->local_area      = $data['local_area'];
            $collectionAddress->city            = $data['city'];
            $collectionAddress->code            = $data['postal_code'];
            $collectionAddress->entered_address = "{$collectionAddress->street_address}, {$collectionAddress->city}, {$collectionAddress->code}";
        }
        return $collectionAddress;
    }

	private function buildDeliveryAddress($data,$method): stdClass
    {
        // dd($data);
        $deliveryAddress = new stdClass();
        if($method == "L2L" || $method == 'D2L'){
        	$deliveryAddress->terminal_id = $data['terminal_id'];
        }
        else{
            $deliveryAddress->type            = $data['type'];
            $deliveryAddress->street_address  = $data['street_address'];
            $deliveryAddress->city            = $data['city'];
            $deliveryAddress->local_area      = $data['local_area'];
            $deliveryAddress->code            = $data['code'];
            $deliveryAddress->zone            = $data['zone'];
            $deliveryAddress->country         = "South Africa";
            $deliveryAddress->entered_address = "{$deliveryAddress->street_address}, {$deliveryAddress->city}, {$deliveryAddress->code}";
        }
        return $deliveryAddress;
    }

	/***********************************************************************/

	/*
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
	*/

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
		dd($response,$data);

		curl_close($ch);

		if ($httpCode >= 200 && $httpCode < 300) {
    		$result = json_decode($response, true);
    		return $result;
    	}
    	Log::error($response);
    	return false;
	}
}
?>
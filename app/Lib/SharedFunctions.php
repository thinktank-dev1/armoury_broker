<?php
namespace App\Lib;

class SharedFunctions{
	
	function getCoordinatesFree($address){
		$token = env('GEO_COORD_TOKEN');

		$formattedAddress = urlencode($address);
		$url = "https://api.mapbox.com/search/geocode/v6/forward?q=".$formattedAddress.'&access_token='.$token;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($ch, CURLOPT_USERAGENT, 'MyPHPGeocodingApp/1.0 (wilson@thinktank.co.za)');

		$response = curl_exec($ch);
		curl_close($ch);

		$data = json_decode($response, true);
		// dd($data);
		if (!empty($data) && isset($data['features'])) {
			$fs = $data['features'];
			foreach($fs AS $f){
				if(isset($f['properties']['coordinates'])){
					return [
						'lon' => $f['properties']['coordinates']['longitude'],
						'lat' => $f['properties']['coordinates']['latitude'],
					];
				}
			}
		}
		return null;
	}
}
?>
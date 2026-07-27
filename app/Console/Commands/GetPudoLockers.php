<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Lib\PudoApi;

class GetPudoLockers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-pudo-lockers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->init();
    }

    public function init(){
        $api = new PudoApi();

        $terminal_values = array_keys($api->lockers);
        $teminal_1 = $terminal_values[0];
        $terminal_2 = $terminal_values[1];

        $rates_data = [
            'collection' => [
                'terminal_id' => $teminal_1,
                'type' => 'business',
                'street' => '51 Sovereign Dr', 
                'local_area' => 'Route 21 Business Park', 
                'city' => 'Centurion', 
                'province' => 'Gauteng',
                'postal_code' => '0157',
            ],
            'delivery' => [
                'terminal_id' => $terminal_2,
                'type' => 'residential',
                'street' => '164 3rd Ave', 
                'local_area' => 'Bezuidenhout Valley', 
                'city' => 'Johannesburg',
                'province' => 'Gauteng', 
                'postal_code' => '2094',
            ],
            'parcels' => [
                [
                    "submitted_width_cm" => 41,
                    "submitted_length_cm" => 69,
                    "submitted_height_cm" => 60,
                    "submitted_weight_kg" => 20,
                    "parcel_description" => "Test Product",
                    "alternative_tracking_reference" => "AB-ORD1234"
                ],
            ],
        ];

        $types = ['L2L','L2D','D2L','D2D'];
        foreach($types AS $tp){
            $rates_data['method'] = $tp;
            $res = $api->getRates($rates_data);
            $this->line($tp.' : '.$res['rate']['rate']);
        }
    }
}

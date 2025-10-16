<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::truncate();
        $settings = [
            "service_fee" => 5,
            "max_offer" => 20,
            "min_fee_amount" => 25,
            "min_gateway_amount" => 10,
        ];

        foreach($settings AS $k => $v){
            Setting::create([
                'name' => $k,
                'value' => $v
            ]);
        }
    }
}

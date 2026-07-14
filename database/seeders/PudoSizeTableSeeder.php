<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\PudoSize;

class PudoSizeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PudoSize::truncate();
        $sizes = [
            [
                'name' => 'Extra Small',
                'width' => 17,
                'height' => 8,
                'length' => 60,
                'max_weight' => 2,
            ],
            [
                'name' => 'Small',
                'width' => 41,
                'height' => 8,
                'length' => 60,
                'max_weight' => 5,
            ],
            [
                'name' => 'Medium',
                'width' => 41,
                'height' => 19,
                'length' => 60,
                'max_weight' => 10,
            ],
            [
                'name' => 'Large',
                'width' => 41,
                'height' => 41,
                'length' => 60,
                'max_weight' => 15,
            ],
            [
                'name' => 'Extra Large',
                'width' => 41,
                'height' => 69,
                'length' => 60,
                'max_weight' => 20,
            ],
        ];
        foreach($sizes AS $sz){
            PudoSize::create([
                'name' => $sz['name'],
                'width' => $sz['width'],
                'height' => $sz['height'],
                'length' => $sz['length'],
                'max_weight' => $sz['max_weight'],
            ]);
        }
    }
}

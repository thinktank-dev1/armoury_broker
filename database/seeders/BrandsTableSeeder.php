<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Brand;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->init();
    }

    public function init(){
        Brand::truncate();
        $brands = [
            [
                'brand_name' => 'Glock',
                'brand_logo' => 'init/brands/Glock.png',
                'featured' => 1,
            ],
            [
                'brand_name' => 'Howa',
                'brand_logo' => 'init/brands/Howa.png',
                'featured' => 1,
            ],
            [
                'brand_name' => 'Savage',
                'brand_logo' => 'init/brands/Savage.png',
                'featured' => 1,
            ],
            [
                'brand_name' => 'Remington',
                'brand_logo' => 'init/brands/Remington.png',
                'featured' => 1,
            ],
            [
                'brand_name' => 'Lee',
                'brand_logo' => 'init/brands/Lee.png',
                'featured' => 1,
            ],
            [
                'brand_name' => 'Hornady',
                'brand_logo' => 'init/brands/Hornady.png',
                'featured' => 1,
            ],
            [
                'brand_name' => 'Dillon',
                'brand_logo' => 'init/brands/Dillon.png',
                'featured' => 1,
            ],
            [
                'brand_name' => 'Hodgdon',
                'brand_logo' => 'init/brands/Hodgdon.png',
                'featured' => 1,
            ],
            [
                'brand_name' => 'Vortex',
                'brand_logo' => 'init/brands/Vortex.png',
                'featured' => 1,
            ],
            [
                'brand_name' => 'Night force',
                'brand_logo' => 'init/brands/Night force.png',
                'featured' => 1,
            ],
            [
                'brand_name' => 'Leupold',
                'brand_logo' => 'init/brands/Leupold.png',
                'featured' => 1,
            ],
            [
                'brand_name' => 'Hawke',
                'brand_logo' => 'init/brands/Hawke.png',
                'featured' => 1,
            ],
        ];

        foreach($brands AS $brand){
            $slug = $this->slugify($brand['brand_name']);
            Brand::create([
                'brand_name' => $brand['brand_name'],
                'slug' => $slug,
                'brand_logo' => $brand['brand_logo'],
                'featured' => $brand['featured'],
            ]);
        }
    }

    public function slugify($string){
        $slug = $string;
        $slug = strtolower($slug);
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $slug);
        $slug = preg_replace('/[^a-z0-9\s]/', ' ', $slug);
        $slug = preg_replace('/\s+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Category;
use App\Models\SubCategory;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::truncate();
        SubCategory::truncate();

        $cats = [
            [
                'name'=>'Ammunition',
                'regulated' => 1,
                'measurement_type' => 'caliber',
                'image' => 'init/AMMUNITION.png',
                'featured' => 1,
                'sub-categories' => [
                    'Semi-automatic pistol Ammunition',
                    'Revolver Ammunition',
                    'Centre Fire Rifle Ammunition',
                    'Rimfire Rifle Ammunition',
                    'Black Powder Rifle Ammunition',
                    'Shotgun Ammunition',
                    'Non-lethal Ammunition',
                ]
            ],
            [
                'name'=>'Firearms',
                'regulated' => 1,
                'measurement_type' => 'caliber',
                'image' => 'init/FIREARMS.png',
                'featured' => 1,
                'sub-categories' => [
                    'Handguns' => [
                        'Antique/Collectible',
                        'Competition Pistols',
                        'Revolvers',
                        'Semi-Automatic Pistols',
                    ],
                    'Rifles' => [
                        'Antique/Collectible',
                        'Double Rifles',
                        'Hunting Rifles',
                        'Lever Action',
                        'Rimfire Rifles',
                        'Semi-Automatic',
                        'Sport/Target Rifles',
                        'Tactical/Modern Sporting',
                        'Black Powder Rifles',
                    ],
                    'Shotguns' => [
                        'Over/Under',
                        'Side-by-Side',
                        'Semi-Automatic',
                        'Pump Action',
                        'Tactical Shotguns',
                    ],
                    'Non-lethal' => [
                        'Handguns',
                        'Rifles',
                        'Air Rifles',
                        'Paintball',
                    ],
                ]
            ],
            [
                'name' => 'Scopes & Optics',
                'regulated' => 0,
                'measurement_type' => 'dimensions',
                'image' => 'init/SCOPES _OPTICS.png',
                'featured' => 1,
                'sub-categories' => [
                    'Binoculars',
                    'Handgun Sights',
                    'Holographic Sights',
                    'Night Vision',
                    'Rangefinders',
                    'Red Dot Sights',
                    'Rifle Scopes',
                    'Spotting Scopes',
                    'Tactical Illuminators',
                    'Thermal Imaging',
                    'Trail Cameras',
                    'Other',
                ]
            ],
            [
                'name' => 'Reloading Equipment',
                'regulated' => 0,
                'measurement_type' => 'dimensions',
                'image' => 'init/RELOADING_EQUIPMENT.png',
                'featured' => 1,
                'sub-categories' => [
                    'Bullet Pullers',
                    'Case Prep Tools',
                    'Dies & Shell Holders',
                    'Powder Measures',
                    'Reloading Kits',
                    'Reloading Manuals',
                    'Reloading Presses',
                    'Reloading Sundry',
                    'Scales & Callipers',
                    'Tumbling Equipment',
                    'Measuring Tools',
                    'Go - No Go Gauges',
                    'Other',
                ]
            ],
            [
                'name' => 'Reloading Components',
                'regulated' => 1,
                'measurement_type' => 'dimensions',
                'featured' => 0,
                'sub-categories' => [
                    'Brass',
                    'Bullets',
                    'Powder',
                    'Primers',
                ]
            ],
            [
                'name'=> 'Safes & Storage',
                'regulated' => 0,
                'measurement_type' => 'dimensions',
                'image' => 'init/SAFES_STORAGE.png',
                'featured' => 1,
                'sub-categories' => [
                    'Cable Locks',
                    'Display Cases',
                    'Lock Boxes',
                    'Pistol Safes',
                    'Rifle Safes',
                    'Safe Accessories',
                    'Trigger Locks',
                    'Vault Doors',
                    'Other',
                ]
            ],
            [
                'name' => 'Shooting Accessories',
                'regulated' => 0,
                'measurement_type' => 'dimensions',
                'featured' => 0,
                'sub-categories' => [
                    'Ammo & Storage',
                    'Arca Rails',
                    'Ballistic Software',
                    'Bipods',
                    'Bore Sighters',
                    'Chronographs',
                    'Clay trap machines',
                    'Clays',
                    'Ear protection',
                    'Eye protection',
                    'Gun rests',
                    'Holsters',
                    'Magazines',
                    'Muzzle Brakes',
                    'Picatinny Rails',
                    'Rear Bags',
                    'Rifle Bags',
                    "Roni's",
                    'Shooting Sticks',
                    'Silencers',
                    'Slings & Straps',
                    'Targets & Stands',
                    'Training Aids',
                    'Tripods',
                    'Wind Meters',
                    'X-Bags',
                    'Other',
                ]
            ],
            [
                'name' => 'Gear',
                'regulated' => 0,
                'measurement_type' => 'size',
                'image' => 'init/TACTICAL_GEAR.png',
                'featured' => 1,
                'sub-categories' => [
                    'Body Armor/Vests',
                    'Clothing',
                    'Communication Gear',
                    'Gloves & Accessories',
                    'Helmets & Protection',
                    'Hunting Clothing',
                    'Lighting & Lasers',
                    'Military Surplus',
                    'Watches',
                    'Communication Devices',
                    'Field Processing Tools',
                    'First aid kits & emergency medical supplies',
                    'Freezers & Cold Storage',
                    'GPS devices & compasses',
                    'Headlamps & lanterns',
                    'Maps & outdoor guides',
                    'Portable stoves & camp cookware',
                    'Ration Packs',
                    'Tents, sleeping bags, & camping chairs',
                    'Water filtration systems & hydration packs',
                ],
            ],
            [
                'name'=>'Gunsmithing & Parts',
                'regulated' => 0,
                'measurement_type' => 'dimensions',
                'image' => 'init/GUNSMITHING & PARTS.png',
                'featured' => 1,
                'sub-categories' => [
                    'Actions',
                    'Barrels',
                    'Rifle Parts & Screw',
                    'Stocks & Chassis',
                    'Triggers',
                    'Other',
                ],
            ],
            [
                'name'=>'Cleaning Equipment',
                'regulated' => 0,
                'measurement_type' => 'dimensions',
                'featured' => 0,
                'sub-categories' => [
                    'Cleaning Accessories',
                    'Cleaning Kits',
                    'Gunsmithing Tools',
                    'Jags & Rods',
                    'Maintenance Tools',
                    'Solvents',
                    'Other',
                ],
            ],
            [
                'name'=>'Knives & Multi-tool',
                'regulated' => 0,
                'measurement_type' => 'dimensions',
                'featured' => 0,
                'sub-categories' => [
                    'Hunting Knives',
                    'Multi-Tools',
                    'Sharpening Equipment',
                    'Survival Tools',
                    'Tactical Knives',
                    'Other',
                ],
            ],
            [
                'name'=>'Hunting & Fishing',
                'regulated' => 0,
                'measurement_type' => 'dimensions',
                'image' => 'init/HUNTING_FISHING.png',
                'featured' => 1,
                'sub-categories' => [
                    'Fishing Rods & Reels',
                    'Fishing Tackle & Lures',
                    'Game Calls & Decoys',
                    'Tree Stands & Blinds',
                    'Other',
                ],
            ],
            [
                'name'=>'Outdoor Vehicles',
                'regulated' => 0,
                'measurement_type' => 'dimensions',
                'featured' => 0,
                'sub-categories' => [
                    'ATVs/Quad Bikes',
                    'Boats & Watercraft',
                    'Camping Trailers',
                    'Hunting Trailers',
                    'Hunting Vehicles',
                    'Vehicle Accessories',
                    'Other',
                ],
            ],
            [
                'name'=>'Services',
                'regulated' => 0,
                'measurement_type' => '',
                'featured' => 0,
                'sub-categories' => [
                    'Annealing & Case Prep',
                    'Appraisal Services',
                    'Butchery/Processing',
                    'Cold Room Storage',
                    'Guided Hunts',
                    'Gunsmithing',
                    'Hunting Packages',
                    'License Motivation',
                    'Load Development',
                    'Mobile Cold Rooms',
                    'Taxidermy',
                    'Training/Instruction',
                    'Other',
                ],
            ],
        ];
        foreach($cats AS $cat){
            $img = null;
            if(isset($cat['image'])){
                $img = $cat['image'];
            }
            $slug = $this->slugify($cat['name']);
            $ct = Category::create([
                'category_name' => $cat['name'],
                'slug' => $slug,
                'category_image' => null,
                'featured' => $cat['featured'],
                'category_image' => $img,
                'status' => '1',
                'regulated' => $cat['regulated'],
                'measurement_type' => $cat['measurement_type'],
            ]);
            foreach($cat['sub-categories'] AS $k => $v){
                if(is_array($v)){
                    $slug2 = $this->slugify($k);
                    $sb = SubCategory::create([
                        'category_id' => $ct->id,
                        'parent_id' => null,
                        'slug' => $slug2,
                        'sub_category_name' => $k
                    ]);
                    foreach($v AS $vv){
                        $slug3 = $this->slugify($vv);
                        SubCategory::create([
                            'category_id' => $ct->id,
                            'parent_id' => $sb->id,
                            'slug' => $slug3,
                            'sub_category_name' => $vv
                        ]);
                    }
                }
                else{
                    $slug4 = $this->slugify($v);
                    $sb = SubCategory::create([
                        'category_id' => $ct->id,
                        'parent_id' => null,
                        'slug' => $slug4,
                        'sub_category_name' => $v
                    ]);
                }
            }
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

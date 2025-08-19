<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Faker\Factory as Faker;

use Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\DeliverOption;
use App\Models\ProductImage;

class FakeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(){
        // $this->createUsers();
        // $this->init();
        $this->changeShippingPices();
    }

    public function changeShippingPices(){
        $faker = Faker::create();
        $dels = DeliverOption::all();
        foreach($dels AS $d){
            $num = $faker->numberBetween($min = 10, $max = 500);
            $d->price = $num;
            $d->save();
        }
    }

    public function createUsers(){
        $faker = Faker::create();
        $gender = ["male", "female"];
        for($i = 0; $i > 100; $i++){
            $role = Role::where('name', 'user')->first();
            $usr = User::create([
                'role_id' => $role->id,
                'name' => $faker->name($gender[array_rand($gender)]),
                'surname' => $faker->lastName(),
                'mobile_number' => $faker->e164PhoneNumber(),
                'email' => $faker->email(),
                'password' => Hash::make($faker->text($maxNbChars = 20)),
                'status' => 1,
                'avatar' => null,
            ]);

            $armoury_name = $faker->company();
            $base = $this->slugify($armoury_name);
            $newName = $base;
            $i = 1;
            while(Vendor::where('url_name', $newName)->first()){
                $newName = $base . $i;
                $i++;
            }

            $vnd = Vendor::create([
                'name' => $armoury_name,
                'url_name' => $newName,
                'avatar' => null,
                'description' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
                'tel' => $faker->e164PhoneNumber(),
                'email' => $faker->email(),
                'street' => $faker->streetAddress(),
                'suburb' => $faker->city(),
                'city' => $faker->city(),
                'country' => $faker->country(),
                'status' => 1,
            ]);
            $usr->vendor_id = $vnd->id;
            $usr->save();
        }
    }

    public function slugify($string){
        $string = strtolower($string);
        $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        $string = preg_replace('/[^a-z0-9]+/', '-', $string);
        $string = trim($string, '-');
        return $string;
    }

    public function init(){
        $faker = Faker::create();

        for ($i = 0; $i < 100; $i++) {
            $user = User::whereNotNull('vendor_id')->inRandomOrder()->first();
            $brand = Brand::inRandomOrder()->first();
            $cat = Category::inRandomOrder()->first();
            $sub = $cat->sub_cats()->inRandomOrder()->first();
            $sub_sub_id = null;
            if($sub->sub_sub->count() > 0){
                $sub_sub = $sub->sub_sub()->inRandomOrder()->first();
                $sub_sub_id = $sub_sub->id;
            }
            $list_types = ['sale', 'wanted'];
            $conditions = [
                "New",
                "Like New",
                "Good",
                "Fair",
                "Parts/Repair",
                "Other",
            ];

            $payers = ['buyer', 'seller', '50-50'];
            $rand = $faker->numberBetween($min = 1, $max = 20);
            $prdt = Product::create([
                'vendor_id' => $user->vendor_id,
                'user_id' => $user->id,
                'brand_id' => $brand->id,
                'category_id' => $cat->id, 
                'sub_category_id' => $sub->id, 
                'sub_sub_category_id' => $sub_sub_id, 
                'listing_type' => $list_types[array_rand($list_types)], 
                'item_name' => $faker->word(), 
                'model_number' => $faker->e164PhoneNumber(), 
                'item_description' => $faker->sentence($nbWords = $rand, $variableNbWords = true), 
                'condition' => $conditions[array_rand($conditions)], 
                'quantity' => $faker->randomDigit(), 
                'size' => $faker->randomDigit(), 
                'service_fee_payer' => $payers[array_rand($payers)], 
                'item_price' => $faker->numberBetween($min = 10, $max = 1000), 
                'allow_offers' => $faker->boolean(), 
                'acknowledgement' => 1,
                'status' => 1,
            ]);
            
            $rand = $faker->numberBetween($min = 1, $max = 5);
            for ($j = 0; $j < $rand; $j++) {
                DeliverOption::create([
                    'product_id' => $prdt->id,
                    'type' => $faker->catchPhrase(),
                    'price' => $faker->numberBetween($min = 1, $max = 1000),
                ]);
            }
            $rand = $faker->numberBetween($min = 1, $max = 3);
            for ($k = 0; $k < $rand; $k++){
                // $w = $faker->numberBetween($min = 200, $max = 200);
                // $h = $faker->numberBetween($min = 200, $max = 200);
                $w = 300;
                $h = 300;

                $url = "https://picsum.photos/".$w."/".$h;
                $saveDir = "public/storage/product_images/";
                $filename = uniqid("image_") . ".jpg";
                $savePath = $saveDir . $filename;

                try{
                    // Download the image
                    $imageData = @file_get_contents($url);

                    if ($imageData !== false) {
                        file_put_contents($savePath, $imageData);

                        ProductImage::create([
                            'product_id' => $prdt->id,
                            'image_url' => 'product_images/'.$filename
                        ]);
                    }
                }
                catch (Exception $e){
                    $this->error($e);
                }
            }
            $this->info("Saved ".$prdt->id);
        }
    }
}

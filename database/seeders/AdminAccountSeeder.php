<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Hash;

use App\Models\Role;
use App\Models\User;
use App\Models\Vendor;

class AdminAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->init();
    }

    public function init(){
        $sourcePath = database_path('seeders/assets/admin.png');
        $fileName = 'admin_' . Str::random(10) . '.png';
        $destinationPath = 'vendor_avater/' . $fileName;

        Storage::disk('public')->put(
            $destinationPath,
            file_get_contents($sourcePath)
        );

        $rl = Role::where('name', 'admin')->first();

        $vnd = Vendor::create([
            'name' => 'Amoury Broker',
            'url_name' => 'amoury-broker',
            'avatar' => $destinationPath,
            // 'banner' => null,
            'description' => 'Aliqua tempor laboris deserunt id nulla eiusmod occaecat in irure. Dolore laborum enim commodo deserunt ex voluptate aliqua anim deserunt amet deserunt culpa.',
            'suburb' => 'Centurion',
            'city' => 'Pretoria',
            'province' => 'Gauteng',
            'instagram_handle' => '@armourybroker',
            'status' => 1,
        ]);

        $usr = User::create([
            'role_id' => $rl->id,
            'vendor_id' => $vnd->id,
            'name' => 'Amoury',
            'surname' => 'Broker',
            'mobile_number' => '0987654321',
            'email' => 'admin@thinktank.co.za',
            'password' => Hash::make('test1234'),
            'status' => 1,
            'avatar' => $destinationPath,
            'email_verified_at' => now(),
        ]);
        $usr->markEmailAsVerified();
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::truncate();
        $roles = [
            'admin' => "Admin user", 
            'user' => "User"
        ];

        foreach($roles AS $name => $description){
            $rl = Role::create([
                'name' => $name,
                'description' => $description
            ]);
        }
    }
}

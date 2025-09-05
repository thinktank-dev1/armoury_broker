<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\File;

use DB;
use Schema;
use Hash;
use App\Models\User;
use App\Models\Role;

class SystemInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:init';

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
        $this->moveInitFilesToPublic();
    }

    public function moveInitFilesToPublic(){
        $source = storage_path('init');
        $destination = storage_path('app/public/init');

        if (!File::exists($source)) {
            $this->error("Source folder does not exist: $source");
            return;
        }

        if (!File::exists($destination)) {
            File::makeDirectory($destination, 0755, true);
        }
        File::copyDirectory($source, $destination);
        $this->info("Folder moved from $source to $destination");
    }

    public function init(){
        $this->info("System Initializing");
        try{
            DB::connection()->getPdo();
            $this->info("DB connection successful");
        }
        catch (\Exception $e) {
            $this->error("Database test failed. Please add you DB connection info in the .env file");
            return 1;
        }

        if(!Schema::hasTable('roles')){
            $this->line("Creating database migration");
            $this->call('migrate');
            $this->line("Seeding Roles table");
            $this->call('db:seed');
        }

        $this->line("Creating Admin User");

        $name = $this->ask("Enter your First Name");
        $surname = $this->ask("Enter your Last Name");
        $mobile_number = $this->ask("Enter your Cellphone Number");
        $email = $this->ask("Enter your Email Address");
        $pass = $this->ask("Enter your Password");

        if(!$name || !$surname || !$email || !$pass){
            $this->error("You did not enter all required data. Re-run the command and enter all required information");
        }
        else{
            $exists = User::where('email', $email)->first();
            if($exists){
                $this->error("The email address has already been taken.");
            }
            else{
                $role = Role::where('name', 'admin')->first();
                if($role){
                    $user = User::create([
                        'role_id' => $role->id,
                        'name' => $name,
                        'surname' => $surname,
                        'mobile_number' => $mobile_number,
                        'email' => $email,
                        'password' => Hash::make($pass),
                        'status' => 1,
                        'email_verified_at' => now(),
                    ]);
                    event(new Registered($user));
                    $this->info("Admin User has been created");
                }
            }
        }
        $this->info("ALL DONE");
    }
}

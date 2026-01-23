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
use App\Imports\CaliberImport;
use Maatwebsite\Excel\Facades\Excel;

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
        $this->loadCalibers();
    }

    public function loadCalibers(){
        $file = storage_path('call/Calibres.xlsx');
        Excel::import(new CaliberImport, $file);
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
        $this->call('storage:link');
        $this->info("ALL DONE");
    }
}

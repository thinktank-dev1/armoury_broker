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
        $res = $api->getTerminals();
        // dd($res);
        if($res){
            foreach($res AS $lc){
                dd($lc);
                if(isset($lc['status'])){
                    $this->info($lc['status']);
                }
                else{
                    // dd($lc);
                    $this->line($lc['code']);
                }
            }
        }
    }
}

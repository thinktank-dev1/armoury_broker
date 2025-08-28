<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;

class EditDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'edit:db';

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
        $this->editCats();
        $this->editSubCats();
        $this->editBrands();
    }

    public function editBrands(){
        $brands = Brand::all();
        foreach($brands AS $br){
            $slug = $br->brand_name;
            $slug = strtolower($slug);
            $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $slug);
            $slug = preg_replace('/[^a-z0-9\s]/', ' ', $slug);
            $slug = preg_replace('/\s+/', '-', $slug);
            $slug = trim($slug, '-');

            $br->slug = $slug;
            $br->save();
        }
    }

    public function editSubCats(){
        $cats = SubCategory::all();
        foreach($cats AS $cat){
            $slug = $cat->sub_category_name;
            $slug = strtolower($slug);
            $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $slug);
            $slug = preg_replace('/[^a-z0-9\s]/', ' ', $slug);
            $slug = preg_replace('/\s+/', '-', $slug);
            $slug = trim($slug, '-');
            $cat->slug = $slug;
            $cat->save();
        }
    }

    public function editCats(){
        $cats = Category::all();
        foreach($cats AS $cat){
            $slug = $cat->category_name;
            $slug = strtolower($slug);
            $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $slug);
            $slug = preg_replace('/[^a-z0-9\s]/', ' ', $slug);
            $slug = preg_replace('/\s+/', '-', $slug);
            $slug = trim($slug, '-');
            $cat->slug = $slug;
            $cat->save();
        }
    } 
}

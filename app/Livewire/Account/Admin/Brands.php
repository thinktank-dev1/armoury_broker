<?php

namespace App\Livewire\Account\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\Brand;

class Brands extends Component
{
    use WithFileUploads;

    public $cur_brand;
    public $brand_name, $brand_logo , $featured;

    public function showEdit($id = null){
        if($id){
            $brand = Brand::find($id);
            if($brand){
                $this->cur_brand = $brand->id;
                $this->brand_name = $brand->brand_name;
                if($brand->featured){
                    $this->featured = true;
                }
            }
        }
        else{
            $this->clearFields();
        }
        $this->dispatch('show-form-modal');
    }

    public function clearFields(){
        $this->cur_brand = null;
        $this->brand_name = null; 
        $this->brand_logo = null;
        $this->featured = false;
    }

    public function saveBrand(){
        $this->validate([
            'brand_name' => 'required',
        ]);
        if($this->cur_brand){
            $brand = Brand::find($this->cur_brand);
        }
        else{
            $brand = new Brand();
        }
        $img_url = null;
        if($this->brand_logo){
            $img_url = $this->brand_logo->storePublicly('brands', 'public');
        }

        $slug = $this->brand_name;
        $slug = strtolower($slug);
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $slug);
        $slug = preg_replace('/[^a-z0-9\s]/', ' ', $slug);
        $slug = preg_replace('/\s+/', '-', $slug);
        $slug = trim($slug, '-');

        $brand->brand_name = $this->brand_name;
        $brand->slug = $slug;
        if($img_url){
            $brand->brand_logo = $img_url;
        }
        $brand->featured = $this->featured;
        $brand->save();
        $this->dispatch('close-modal');
        $this->clearFields();
    }

    public function render(){
        $brands = Brand::orderBy('brand_name', 'ASC')->get();
        return view('livewire.account.admin.brands', [
            'brands' => $brands
        ]);
    }
}

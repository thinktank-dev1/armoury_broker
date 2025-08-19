<?php

namespace App\Livewire\Account\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\Category;
use App\Models\SubCategory;

class Categories extends Component
{
    use WithFileUploads;

    public $sub_cats = [];
    public $category_name, $category_image;
    public $cur_id;
    public $cats_std = [];

    public function showModal($id = null){
        if(!$id){
            $this->category_name = null;
            $this->category_image = null;
            $this->sub_cats = [];
            $arr = [
                "name" => null,
                "id" => null
            ];
            $this->sub_cats[] = $arr;
        }
        else{
            $cat = Category::find($id);
            if($cat){
                $this->cur_id = $id;
                $this->category_name = $cat->category_name;
                $this->sub_cats = [];
                if($cat->sub_cats->count() > 0){
                    foreach($cat->sub_cats AS $sub){
                        $arr = [
                            "id" => $sub->id,
                            "name" => $sub->sub_category_name,
                        ];
                        $this->sub_cats[] = $arr;
                    }
                }
                else{
                    $arr = [
                        "name" => null,
                        "id" => null
                    ];
                    $this->sub_cats[] = $arr;
                }
            }
        }
        $this->dispatch('show-add-category-modal'); 
    }

    public function removeCategory($id){
        $cat = Category::find($id);
        if($cat){
            foreach($cat->sub_cats AS $sub){
                $sub->delete();
            }
            $cat->delete();
        }
    }

    public function reoveSubCategory($id){
        $sub = SubCategory::find($id);
        if($sub){
            $cat_id = $sub->category_id;
            $sub->delete();
            $this->getSubCats($cat_id);
        }
    }

    public function getSubCats($id){
        $this->cats_std = SubCategory::where('category_id', $id)->get();
    }

    public function addSubCat(){
        $arr = [
            "name" => null,
            "id" => null
        ];
        $this->sub_cats[] = $arr;
    }

    public function saveCategory(){
        $this->validate([
            'category_name' => 'required',
        ]);
        if($this->cur_id){
            $cat = Category::find($this->cur_id);
        }
        else{
            $cat = new Category();
        }
        $img = null;
        if($this->category_image){
            $img = $this->category_image->storePublicly('category_images', 'public');
        }
        $cat->category_name = $this->category_name;
        if($img){
            $cat->category_image = $img;
        }
        $cat->save();

        foreach($this->sub_cats AS $subs){
            if($subs['id']){
                $sub = SubCategory::find($subs['id']);
            }
            else{
                $sub = new SubCategory();
            }
            $sub->category_id = $cat->id;
            $sub->sub_category_name = $subs['name'];
            $sub->save();
        }
        $this->dispatch('close-modal'); 
        $this->getSubCats($cat->id);
    }

    public function render(){
        $cats = Category::orderBy('category_name', 'ASC')->get();
        return view('livewire.account.admin.categories', [
            "cats" => $cats
        ]);
    }
}

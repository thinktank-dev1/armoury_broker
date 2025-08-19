<?php

namespace App\Livewire\Account\Admin\Products;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;

class AdminPoductsList extends Component
{
    use WithPagination;

    public $search_key, $category_search, $sub_category_search, $sub_sub_cats_search;
    public $sub_cats = [], $sub_sub_cats = [];

    public function setFeatured($id){
        $prdt = Product::find($id);
        if($prdt){
            if($prdt->featured == 0 || $prdt->featured == null){
                $prdt->featured = 1;
            }
            else{
                $prdt->featured = 0;
            }
            $prdt->save();
        }
    }

    public function updatedSubCategorySearch(){
        $this->resetPage();
        $sub = SubCategory::where('parent_id', $this->sub_category_search)->get();
        if($sub->count() > 0){
            $this->sub_sub_cats = $sub;
        }
    }

    public function updatedCategorySearch(){
        $this->resetPage();
        $this->sub_cats = [];
        $this->sub_sub_cats = [];
        if($this->category_search){
            $subs = SubCategory::where('category_id', $this->category_search)->whereNull('parent_id')->get();
            if($subs){
                $this->sub_cats = $subs;
            }
        }
    }

    public function updatedSearchKey(){
        $this->resetPage();
        $this->sub_cats = [];
        $this->sub_sub_cats = [];
    }

    public function render(){
        $key = $this->search_key;
        $cat = $this->category_search;
        $sub = $this->sub_category_search;
        $sub_sub = $this->sub_sub_cats_search;

        $products = Product::query()
        ->when($key, function($q) use($key){
            return $q->where('item_name', 'LIKE', '%'.$key.'%')
            ->orWhere('item_description', 'LIKE', '%'.$key.'%')
            ->orWhere('model_number', 'LIKE', '%'.$key.'%');
        })
        ->when($cat, function($q) use($cat){
            return $q->where('category_id', $cat);
        })
        ->when($sub, function($q) use($sub){
            return $q->where('sub_category_id', $sub);
        })
        ->when($sub_sub, function($q) use($sub_sub){
            return $q->where('sub_sub_category_id', $sub_sub);
        })
        ->orderBy('item_name', 'ASC')
        ->paginate(12);

        $cats = Category::orderBy('category_name', 'ASC')->get();

        return view('livewire.account.admin.products.admin-poducts-list', [
            'products' => $products,
            'cats' => $cats
        ]);
    }
}

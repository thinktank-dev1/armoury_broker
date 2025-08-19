<?php

namespace App\Livewire\Landing;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\Product;

class Shop extends Component
{
    public $page_title;
    public $conditions = [], $sort_options = [];
    public $results_count, $current_filters = [];
    public $static_min_price, $static_max_price, $max_price, $min_price;
    public $sort_by;
    public $search_key;

    public function mount(){
        if(isset($_GET['category'])){
            $this->current_filters['category'][] = $_GET['category'];
        }
        if(isset($_GET['sub-category'])){
            $this->current_filters['sub-category'][] = $_GET['sub-category'];
        }
        if(isset($_GET['sub-sub-category'])){
            $this->current_filters['sub-sub-category'][] = $_GET['sub-sub-category'];
        }
        if(isset($_GET['brands'])){
            $this->current_filters['brands'][] = $_GET['brands'];
        }
        if(isset($_GET['search'])){
            $this->search_key = $_GET['search'];
        }
        $this->setStaticData();
    }

    public function updatedMaxPrice(){}

    public function updateFilters($type, $value){
        if($type == 'sub-category'){
            $sub = SubCategory::where('slug', $value)->first();
            if($sub){
                if(isset($this->current_filters['category'])){
                    if(!in_array($sub->category->slug, $this->current_filters['category'])){
                        $this->current_filters['category'][] = $sub->category->slug;
                    }
                }
                else{
                    $this->current_filters['category'][] = $sub->category->slug;
                }
            }
        }
        if (array_key_exists($type, $this->current_filters)){
            if(in_array($value, $this->current_filters[$type])){
                $key = array_search($value, $this->current_filters[$type]);
                unset($this->current_filters[$type][$key]);
            }
            else{
                $this->current_filters[$type][] = $value;
            }
        }
        else{
            $this->current_filters[$type][] = $value;
        }
    }

    public function setStaticData(){
        $this->conditions = [
            "New",
            "Like New",
            "Good",
            "Fair",
            "Parts/Repair",
            "Other",
        ];
        $this->sort_options = [
            'Price (Low - High)',
            'Price (High - Low)',
            'Newest Listed',
            'Oldest Listed',
            'Most Popular',
        ];
        $this->results_count = 0;
    }

    #[Layout('components.layouts.landing')] 
    public function render(){
        $filters = $this->current_filters;
        $key = $this->search_key;

        $query = Product::query();
        if(count($filters) > 0){
            foreach($filters AS $k => $v){
                if($k == "category"){
                    $query->whereHas('category', function($q) use($v){
                        return $q->whereIn('slug', $v);
                    });
                }
                if($k == "sub-category"){
                    $query->whereHas('subCategory', function($q) use($v){
                        return $q->whereIn('slug', $v);
                    });
                }
                if($k == "brands"){
                    $query->whereHas('brand', function($q) use($v){
                        return $q->whereIn('slug', $v);
                    });
                }
                if($k == 'condition'){
                    $query->whereIn('condition', $v);
                }
            }
        }
        if($this->min_price){
            $query->where('item_price', '>=', $this->min_price);
        }
        if($this->max_price){
            $query->where('item_price', '<=', $this->max_price);
        }

        if($key){
            $query->where('item_name', 'LIKE', '%'.$key.'%')
            ->orWhere('item_description', 'LIKE', '%'.$key.'%');
        }

        if($this->sort_by){
            if($this->sort_by == 'Price (Low - High)'){
                $query->orderBy('item_price', 'ASC');
            }
            if($this->sort_by == 'Price (High - Low)'){
                $query->orderBy('item_price', 'DESC');
            }
            if($this->sort_by == 'Newest Listed'){
                $query->orderBy('created_at', 'DESC');
            }
            if($this->sort_by == 'Oldest Listed'){
                $query->orderBy('created_at', 'ASC');
            }
            // if($this->sort_by == 'Most Popular')
        }
        $products = $query->paginate(16);
        $this->results_count = $products->total();
        
        $min_max_query = Product::query();
        if(count($filters) > 0){
            foreach($filters AS $k => $v){
                if($k == "category"){
                    $min_max_query->whereHas('category', function($q) use($v){
                        return $q->whereIn('slug', $v);
                    });
                }
                if($k == "sub-category"){
                    $min_max_query->whereHas('subCategory', function($q) use($v){
                        return $q->whereIn('slug', $v);
                    });
                }
                if($k == "brands"){
                    $min_max_query->whereHas('brand', function($q) use($v){
                        return $q->whereIn('slug', $v);
                    });
                }
                if($k == 'condition'){
                    $min_max_query->whereIn('condition', $v);
                }
            }
        }
        if($this->min_price){
            $min_max_query->where('item_price', '>=', $this->min_price);
        }
        if($this->max_price){
            $min_max_query->where('item_price', '<=', $this->max_price);
        }
        $min_max = $min_max_query->selectRaw('MIN(item_price) as min_price, MAX(item_price) as max_price')->first();
        $this->static_min_price = $min_max->min_price;
        $this->static_max_price = $min_max->max_price;



        $cats = Category::orderBy('category_name', 'ASC')->get();
        $brands = Brand::orderBy('brand_name', 'ASC')->get();
        return view('livewire.landing.shop', [
            'cats' => $cats,
            'brands' => $brands,
            'products' => $products
        ]);
    }
}

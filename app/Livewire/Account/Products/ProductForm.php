<?php

namespace App\Livewire\Account\Products;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

use Auth;
use App\Models\Vendor;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\Setting;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\DeliverOption;

class ProductForm extends Component
{
    use WithFileUploads;

    public $cur_id;
    public $category, $sub_sub = [], $conditions = [], $sizes = [];
    public $listing_type, $item_name, $model_number, $item_description, $category_id, $sub_category_id, $sub_sub_category_id, $brand_id, $condition, $quantity, $size, $service_fee_payer, $item_price, $allow_offers, $acknowledgement;
    public $shipping_types = [], $product_images = [];
    public $cur_images = [];
    public $allow_collection, $collection_address;
    public $delivery_type;
    public $deler_stock;
    public $in_person_delivery;

    public function mount($id = null){
        if(!Auth::user()->vendor_id){
            return redirect('my-armoury/edit')->with('error', 'Please fill in this form before you can upload products!');
        }
        $this->setStaticData();
        $this->addShippingType();

        if($id){
            $this->cur_id = $id;
            $this->getData();
        }
    }

    public function updatedProductImages(){
        foreach($this->product_images AS $key => $img){
            if($img){
                $tp = $img->getMimeType();
                if(!str_starts_with($tp, 'image/')){
                    unset($this->product_images[$key]);
                    $this->addError('error', 'Please upload images only');
                }
            }
        }
    }

    public function removeImage($key){
        $this->product_images[$key] = null;
    }

    public function removeShipping($key){
        $tp = $this->shipping_types[$key];
        if(isset($tp['id'])){
            $sh = DeliverOption::find($tp['id']);
            if($sh){
                $sh->delete();
            }
        }
        unset($this->shipping_types[$key]);
    }

    public function getData(){
        $prdt = Product::find($this->cur_id);
        if($prdt){
            $this->listing_type = $prdt->listing_type;
            $this->item_name = $prdt->item_name;
            $this->model_number = $prdt->model_number;
            $this->item_description = $prdt->item_description;
            $this->category_id = $prdt->category_id;
            $this->sub_category_id = $prdt->sub_category_id;
            $this->sub_sub_category_id = $prdt->sub_sub_category_id;
            $this->brand_id = $prdt->brand_id;
            $this->condition = $prdt->condition;
            $this->quantity = $prdt->quantity;
            $this->size = $prdt->size;
            $this->service_fee_payer = $prdt->service_fee_payer; 
            $this->item_price = $prdt->item_price;
            if($this->allow_offers){
                $this->allow_offers = true;
            }
            $this->acknowledgement = true;
            if($prdt->allow_collection){
                $this->allow_collection = true;
            }
            $this->collection_address = $prdt->collection_address;
            if($prdt->delivery_type == "in person"){
                $this->in_person_delivery = true;
            }
            else{
                $this->delivery_type = $prdt->delivery_type;
                $this->in_person_delivery = null;
            }
            if($prdt->deler_stock){
                $this->deler_stock = true;
            }


            if($prdt->shippingOptions->count() > 0){
                $this->shipping_types = [];
                foreach($prdt->shippingOptions AS $opt){
                    $arr = [
                        "id" => $opt->id,
                        "type" => $opt->type,
                        "cost" => $opt->cost,
                    ];
                    $this->shipping_types[] = $arr;
                }
            }
            $this->category = Category::find($this->category_id);
        }
    }

    public function saveProduct(){
        $this->dispatch('go-to-top');
        $this->validate([
            'listing_type' => 'required', 
            'item_name' => 'required',  
            'item_description' => 'required', 
            'category_id' => 'required', 
            'sub_category_id' => 'required',  
            'brand_id' => 'required', 
            'condition' => 'required', 
            'quantity' => 'required',  
            'service_fee_payer' => 'required', 
            'item_price' => 'required',  
            'acknowledgement' => 'required'
        ]);
        if($this->cur_id){
            $prdt = Product::find($this->cur_id);
        }
        else{
            $prdt = new Product();
        }
        
        $prdt->vendor_id = Auth::user()->vendor_id;
        $prdt->user_id = Auth::user()->id;
        $prdt->brand_id = $this->brand_id;
        $prdt->category_id = $this->category_id;
        $prdt->sub_category_id = $this->sub_category_id;
        $prdt->sub_sub_category_id = $this->sub_sub_category_id;
        $prdt->listing_type = $this->listing_type;
        $prdt->item_name = $this->item_name;
        $prdt->model_number = $this->model_number;
        $prdt->item_description = $this->item_description;
        $prdt->condition = $this->condition;
        $prdt->quantity = $this->quantity;
        $prdt->size = $this->size;
        $prdt->service_fee_payer = $this->service_fee_payer;
        $prdt->item_price = $this->item_price;
        $prdt->allow_offers = $this->allow_offers;
        $prdt->acknowledgement = $this->acknowledgement;
        $prdt->status = 1;
        $prdt->allow_collection = $this->allow_collection;
        $prdt->collection_address = $this->collection_address;
        if($this->in_person_delivery){
            $prdt->delivery_type = 'in person';
        }
        else{
            $prdt->delivery_type = $this->delivery_type;
        }
        $prdt->deler_stock = $this->deler_stock;
        $prdt->save();

        foreach($this->product_images AS $image){
            if($image){
                $file = $image->storePublicly('product_images', 'public');
                ProductImage::create([
                    'product_id' => $prdt->id,
                    'image_url' => $file
                ]);
            }
        }

        foreach($this->shipping_types AS $type){
            if($type['type'] != "" && $type['cost'] != ""){
                DeliverOption::create([
                    'product_id' => $prdt->id,
                    'type' => $type['type'],
                    'price' => $type['cost'],
                ]);
            }
        }
        session()->flash('status', 'Product successfully listed.');
        return redirect('my-armoury');
    }

    public function addShippingType(){
        $arr = [
            "type" => null,
            "cost" => null,
        ];
        $this->shipping_types[] = $arr;
    }

    public function updatedSubCategoryId(){
        $sub = SubCategory::find($this->sub_category_id);
        if($sub){
            $sub_sub = SubCategory::where('parent_id', $sub->id)->get();
            foreach($sub_sub AS $sb){
                $arr = [
                    'id' => $sb->id,
                    'name' => $sb->sub_category_name,
                ];
                $this->sub_sub[] = $arr;
            }
        }
    }

    public function updatedCategoryId(){
        $this->sub_category_id = null;
        $this->sub_sub = [];
        $this->category = Category::find($this->category_id);
    }

    public function setStaticData(){
        $this->listing_type = 'sale';
        $this->product_images = [
            "image_1" => null,
            "image_2" => null,
            "image_3" => null,
            "image_4" => null,
            "image_5" => null,
            "image_6" => null,
        ];
        $this->conditions = [
            "New",
            "Like New",
            "Good",
            "Fair",
            "Parts/Repair",
            "Other",
        ];
        $this->sizes = [
            "XS",
            "S",
            "M",
            "L",
            "XL",
            "2XL",
            "3XL",
            "Other",
        ];
    }

    public function setListingType($type){
        $this->listing_type = $type;
    }

    public function render(){
        $cats = Category::orderBy('category_name', 'ASC')->get();
        $brands = Brand::orderBy('brand_name', 'ASC')->get();
        
        $fee = 0;
        $max_offer = 0;
        $sevice_fee = Setting::where('name', 'service_fee')->first();
        $offer_limit = Setting::where('name', 'max_offer')->first();
        if($sevice_fee){
            $fee = $sevice_fee->value;
        }
        if($offer_limit){
            $max_offer = $offer_limit->value;
        }
        return view('livewire.account.products.product-form', [
            "cats" => $cats,
            'brands' => $brands,
            'fee' => $fee,
            'max_offer' => $max_offer,
        ]);
    }
}

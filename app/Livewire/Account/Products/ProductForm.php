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
use App\Models\Caliber;
use App\Models\Dealer;

class ProductForm extends Component
{
    use WithFileUploads;

    public $cur_id, $cur_product;
    public $category, $sub_sub = [], $conditions = [], $sizes = [];
    public $listing_type, $item_name, $model_number, $item_description, $category_id, $sub_category_id, $sub_sub_category_id, $brand_id, $condition, $quantity, $size, $service_fee_payer, $item_price, $allow_offers, $acknowledgement;
    public $product_images = [];
    public $cur_images = [];
    public $collection_delivery, $courier, $dealer_stock, $free_delivery;
    public $preview, $preview_quantity, $sub_name, $brand_name, $sub_sub_name;
    public $dealer_stock_type, $ab_dealer_id, $private_dealer_details;

    public function mount($id = null){
        if(!Auth::user()->vendor_id){
            return redirect('my-armoury/edit')->with('error', 'Please fill in this form before you can upload products!');
        }
        $this->setStaticData();

        if($id){
            $this->cur_id = $id;
            $this->getData();
        }
        $this->preview = True;
        $this->preview_quantity = 1;
    }

    public function removeItem(){
        if($this->cur_id){
            $prdt = Product::find($this->cur_id);
            if($prdt){
                $prdt->status = 0;
                $prdt->save();

                return redirect('my-armoury');
            }
        }
    }

    public function updatedCourier(){
        if($this->courier){
            $this->free_delivery = null;
        }
    }

    public function updatedFreeDelivery(){
        if($this->free_delivery){
            $this->courier = null;
        }
    }

    public function updatedSubSubCategoryId(){
        $sb = SubCategory::find($this->sub_sub_category_id);
        if($sb){
            $this->sub_sub_name = $sb->sub_category_name;
        }
    }

    public function updatedBrandId(){
        $br = Brand::find($this->brand_id);
        if($br){
            $this->brand_name = $br->brand_name;
        }
    }

    public function updatePreviewQty($tp){
        if($tp == 'minus'){
            if($this->preview_quantity > 1){
                $this->preview_quantity -= 1;
            }
        }
        if($tp == "plus"){
            if($this->preview_quantity < $this->quantity){
                $this->preview_quantity += 1;
            }
        }
    }

    public function togglePreview(){
        $this->preview = !$this->preview;
        $this->dispatch('go-to-top');
    }

    public function updatedQuantity(){
        if($this->quantity < 1){
            $this->quantity = 1;
        }
    }

    public function updatedProductImages(){
        foreach($this->product_images AS $key => $img){
            if($img){
                $tp = $img->getMimeType();
                $allowed = ['image/png', 'image/jpg', 'image/jpeg'];
                if(!in_array($tp, $allowed)){
                // if(!str_starts_with($tp, 'image/')){
                    // unset($this->product_images[$key]);
                    $this->product_images[$key] = null;
                    $this->addError('error', 'Please upload images only. (PNG, JPEG, JPG)');
                }
            }
        }
    }

    public function removeImage($key){
        $this->product_images[$key] = null;
    }

    public function deleteImage($id){
        $img = ProductImage::find($id);
        if($img){
            $img->delete();
        }
    }

    public function getData(){
        $prdt = Product::find($this->cur_id);
        if($prdt){
            $this->cur_product = $prdt;
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
            if($prdt->allow_offers){
                $this->allow_offers = true;
            }

            $this->dealer_stock_type = $prdt->dealer_stocking_type;
            $this->ab_dealer_id = $prdt->dealer_id;
            $this->private_dealer_details = $prdt->private_dealer_details;

            $this->acknowledgement = true;
            if($prdt->allow_collection){
                $this->allow_collection = true;
            }
            foreach($prdt->shippingOptions AS $opt){
                $tp = $opt->type;
                $this->$tp = true;
            }
            $this->category = Category::find($this->category_id);
        }
    }

    public function saveProduct(){
        $this->dispatch('go-to-top');
        $rules = [
            'listing_type' => 'required',
            'item_name' => 'required',
            'item_description' => 'required',
            'category_id' => 'required',
            'quantity' => 'required',
        ];
        $messages = [
            'item_name.required' => 'Listing title field is required',
            'category_id.required' => 'Please select a category',
        ];
        if($this->listing_type == "sale"){
            $rules['service_fee_payer'] = 'required';
            $rules['item_price'] = 'required';
            $rules['acknowledgement'] = 'required';

            $messages['acknowledgement.required'] = 'You did not accept the terms and conditions';
        }

        if($this->dealer_stock){
            $rules['dealer_stock_type'] = 'required';
            if($this->dealer_stock_type == 'ab_dealer'){
                $rules['ab_dealer_id'] = 'required';
            }
            elseif($this->dealer_stock_type == 'custom_dealer'){
                $rules['private_dealer_details'] = 'required';
            }
        }

        $has_images = false;
        foreach($this->product_images AS $img){
            if($img){
                $has_images = true;
                break;
            }
        }
        if(!$this->cur_id){
            if(!$has_images){
                $this->addError('error', 'Please upload at least 1 image ');
                return;
            }
        }        

        $this->validate($rules, $messages);
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

        $prdt->dealer_stocking_type = $this->dealer_stock_type;
        $prdt->dealer_id = $this->ab_dealer_id;
        $prdt->private_dealer_details = $this->private_dealer_details;

        $prdt->acknowledgement = $this->acknowledgement;
        $prdt->status = 1;
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

        $ships = ['collection_delivery', 'courier', 'dealer_stock', 'free_delivery'];
        foreach($ships AS $sh){
            $price = 0;
            if($sh == "courier"){
                $price = 99;
            }
            $del = DeliverOption::where('type', $sh)->where('product_id', $prdt->id)->first();
            if($this->$sh){
                if(!$del){
                    DeliverOption::create([
                        'product_id' => $prdt->id,
                        'type' => $sh,
                        'price' => $price,
                    ]);
                }    
            }
            else{
                if($del){
                    $del->delete();
                }
            }
        }
        $this->dispatch('item-saved', id:$prdt->id);
    }

    public function updatedSubCategoryId(){
        $sub = SubCategory::find($this->sub_category_id);
        if($sub){
            $this->sub_name = $sub->sub_category_name;
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

        $calibers = Caliber::orderBy('caliber', 'ASC')->get();

        $dealers = Dealer::where('province', Auth::user()->vendor->province)->get();

        return view('livewire.account.products.product-form', [
            "cats" => $cats,
            'brands' => $brands,
            'fee' => $fee,
            'max_offer' => $max_offer,
            'calibers' => $calibers,
            'dealers' => $dealers
        ]);
    }
}

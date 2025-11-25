<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'featured',
        'vendor_id',
        'user_id',
        'brand_id',
        'category_id', 
        'sub_category_id', 
        'sub_sub_category_id', 
        'listing_type', 
        'item_name', 
        'model_number', 
        'item_description', 
        'condition', 
        'quantity', 
        'size', 
        'service_fee_payer', 
        'item_price', 
        'allow_offers', 
        'acknowledgement',
        'allow_collection',
        'collection_address',
        'delivery_type',
        'deler_stock',

        'dealer_stocking_type',
        'dealer_id',
        'private_dealer_details',

        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function images(){
        return $this->hasMany(ProductImage::class);
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function subCategory(){
        return $this->belongsTo(SubCategory::class);
    }

    public function sub_sub(){
        return $this->belongsTo(SubCategory::class, 'sub_sub_category_id');
    }

    public function wishlists(){
        return $this->hasMany(WishList::class);
    }

    public function shippingOptions(){
        return $this->hasMany(DeliverOption::class);
    }

    public function orders(){
        return $this->hasMany(OrderItem::class);
    }
}

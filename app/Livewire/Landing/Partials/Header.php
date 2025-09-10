<?php

namespace App\Livewire\Landing\Partials;

use Livewire\Component;

use App\Models\Category;
use App\Models\SubCategory;

use Auth;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Message;

class Header extends Component
{
    public $subs = [], $sub_subs;
    public $cur_cat_id;
    public $cart_count;

    public $menu_col, $show_third_level_menu, $sub_row_count;

    public function mount(){
        $this->getSubCats(Category::orderBy('category_name', 'ASC')->first()->id);
        $this->getCartCount();

        $this->menu_col = "col-lg-6";
        $this->show_third_level_menu = false;
    }

    public function getCartCount(){
        if(!Auth::guest()){
            $order_items_count = OrderItem::query()
            ->where('user_id', Auth::user()->id)
            ->whereNull('order_id')
            ->count();

            $this->cart_count += $order_items_count;
        }
        $cart = session()->get('cart');
        if($cart){
            $count = count($cart);
            $this->cart_count += $count;
        }
    }

    public function getSubSub($id){
        $sub = SubCategory::find($id);
        if($sub){
            if($sub->sub_sub->count() > 0){
                $this->sub_subs = $sub->sub_sub;
                $this->menu_col = "col-lg-4";
            }
            else{
                return redirect('category/'.strtolower(str_replace(' ','-', $sub->category->category_name)).'/'.strtolower(str_replace(' ','-', $sub->sub_category_name)));
            }
        }
    }

    public function getSubCats($id){
        $cats_count = Category::orderBy('category_name', 'ASC')->count();

        $this->sub_subs = [];
        $this->subs = [];
        $this->menu_col = "col-lg-6";
        $this->show_third_level_menu = false;
        $cat = Category::find($id);
        if($cat){
            if($cat->sub_cats->count() > 0){
                $this->cur_cat_id = $cat->id;
                $subs = $cat->sub_cats->whereNull('parent_id');

                if($cats_count < $subs->count()){
                    $this->menu_col = "col-lg-4"; 
                    $this->show_third_level_menu = true;
                    $this->sub_row_count = intdiv($subs->count(), 2);
                }
                else{
                    $this->menu_col = "col-lg-6"; 
                    $this->show_third_level_menu = false;
                    $this->sub_row_count = null;
                }
                $this->subs = $subs;
            }
            else{
                return redirect('category/'.strtolower(str_replace(' ','-', $cat->category_name)));
            }
        }
    }

    public function render(){
        $categories = Category::orderBy('category_name', 'ASC')->get();

        $msg_count = null;
        if(!Auth::guest()){
            if(Auth::user()->vendor_id){
                $msg_count = Message::where('vendor_id', Auth::user()->vendor_id)->where('status', 0)->count();
            }
        }

        return view('livewire.landing.partials.header', [
            'categories' => $categories,
            'msg_count' => $msg_count
        ]);
    }
}

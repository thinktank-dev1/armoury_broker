<?php

namespace App\Livewire\Account\Admin\Categories;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

use App\Models\Category;
use App\Models\SubCategory;

class ListCategories extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search_key;
    public $cur_cat_id, $cur_cat;
    public $category_name, $category_image, $status, $regulated, $featured, $measurement_type;
    public $show_subs = false;
    public $cur_sub_id, $cur_parent_id, $sub_category_name;
    public $show_sub_sub = false;

    public function showSubSub($id){
        $this->cur_sub_id = $id;
        $this->show_sub_sub = true;
    }

    public function saveSubCategory(){
        $this->validate([
            'sub_category_name' => 'required',
        ]);
        if($this->cur_sub_id){
            $sub = SubCategory::find($this->cur_sub_id);
        }
        else{
            $sub = new SubCategory();
        }

        $slug = $this->sub_category_name;
        $slug = strtolower($slug);
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $slug);
        $slug = preg_replace('/[^a-z0-9\s]/', ' ', $slug);
        $slug = preg_replace('/\s+/', '-', $slug);
        $slug = trim($slug, '-');

        $sub->category_id = $this->cur_cat_id;
        if($this->cur_parent_id){
            $sub->parent_id = $this->cur_parent_id;
        }
        $sub->sub_category_name = $this->sub_category_name;
        $sub->slug = $slug;
        $sub->save();
        $this->dispatch('close-modal');
    }

    public function showSubCatModal($cat_id, $sub_id = null, $child_id = null, $action){
        $this->cur_cat_id = $cat_id;
        if($action == "new"){
            if(!$sub_id){
                $this->cur_sub_id = null;
                $this->cur_parent_id = null;
                $this->sub_category_name = null;
            }
            else{
                $this->cur_sub_id = null;
                $this->cur_parent_id = $sub_id;
                $this->sub_category_name = null;
            }
        }
        elseif($action == "edit"){
            if(!$child_id){
                $sub = SubCategory::find($sub_id);
                if($sub){
                    $this->cur_sub_id = $sub->id;
                    $this->cur_parent_id = null;
                    $this->sub_category_name = $sub->sub_category_name;
                }
            }
            else{
                $sub = SubCategory::find($child_id);
                if($sub){
                    $this->cur_sub_id = $sub->id;
                    $this->cur_parent_id = $sub->parent_id;
                    $this->sub_category_name = $sub->sub_category_name;
                }
            }
        }
        $this->dispatch('show-sub-category-modal');
    }

    public function showSubCats($id){
        $cat = Category::find($id);
        $this->show_sub_sub = false;
        if($cat){
            $this->show_subs = true;
            $this->cur_cat = $cat;
        }
    }

    public function updatedSearchKey(){
        $this->resetPage();
    }

    public function showEdit($id = null){
        if($id){
            $cat = Category::find($id);
            if($cat){
                $this->cur_cat_id = $id;
                $this->category_name = $cat->category_name; 
                $this->category_image = null;
                $this->status = $cat->status;
                $this->measurement_type = $cat->measurement_type;
                if($cat->regulated){
                    $this->regulated = true;
                }
                if($cat->featured){
                    $this->featured = true;
                }
            }
            else{
                $this->clearFields();
            }
        }
        else{
            $this->clearFields();
        }
        $this->dispatch('show-category-modal');
    }

    public function clearFields(){
        $this->cur_cat_id = null;
        $this->category_name = null;
        $this->category_image = null;
        $this->status = null;
        $this->regulated = false;
        $this->featured = false;
        $this->measurement_type = null;
    }

    public function saveCategory(){
        $this->validate([
            'category_name' => 'required',
        ]);
        if($this->cur_cat_id){
            $cat = Category::find($this->cur_cat_id);
        }
        else{
            $cat = new Category();
        }
        $img_url = null;
        if($this->category_image){
            $img_url = $this->category_image->storePublicly('category_images', 'public');
        }
        $slug = $this->category_name;
        $slug = strtolower($slug);
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $slug);
        $slug = preg_replace('/[^a-z0-9\s]/', ' ', $slug);
        $slug = preg_replace('/\s+/', '-', $slug);
        $slug = trim($slug, '-');

        $cat->category_name = $this->category_name;
        $cat->slug = $slug;
        if($img_url){
            $cat->category_image = $img_url;
        }
        $cat->measurement_type = $this->measurement_type;
        $cat->featured = $this->featured;
        $cat->status = $this->status;
        $cat->regulated = $this->regulated;
        $cat->save();
        $this->dispatch('close-modal');
        $this->clearFields();
    }

    public function deleteCategory($id){
        $cat = Category::find($id);
        if($cat){
            foreach($cat->sub_cats AS $sub){
                $sub->delete();
            }
            $cat->delete();
        }
    }

    public function render(){
        $key = $this->search_key;

        $categories = Category::query()
        ->when($key, function($q) use($key){
            return $q->where('category_name', 'LIKE', '%'.$key.'%');
        })
        ->orderBy('category_name', 'ASC')
        ->get();
        return view('livewire.account.admin.categories.list-categories', [
            'categories' => $categories
        ]);
    }
}

<?php

namespace App\Livewire\Account\Admin;

use Livewire\Component;
use Livewire\WithPagination;

use Hash;
use App\Models\User;
use App\Models\Role;

class ListUsers extends Component
{
    use WithPagination;

    public $search_key;
    public $cur_id;
    public $name, $surname, $mobile_number, $email, $password;

    public function showEdit($id = null){
        if(!$id){
            $this->clearFields();
        }
        else{
            $usr = User::find($id);
            if($usr){
                $this->cur_id = $usr->id;
                $this->name = $usr->name;
                $this->surname = $usr->surname;
                $this->mobile_number = $usr->mobile_number;
                $this->email = $usr->email;
                $this->password = null;
            }
        }
        $this->dispatch('show-form'); 
    }

    public function clearFields(){
        $this->cur_id = null;
        $this->name = null;
        $this->surname = null;
        $this->mobile_number = null;
        $this->email = null;
        $this->password = null;
    }

    public function changeUserStatus($id, $status){
        $usr = User::find($id);
        if($usr){
            $usr->status = $status;
            $usr->save();
        }
    }

    public function updatedSearchKey(){
        $this->resetPage();
    }

    public function saveUser(){
        $rules = [
            'name' => 'required', 
            'surname' => 'required', 
            'mobile_number' => 'required'
        ];
        if(!$this->cur_id){
            $rules['password'] = 'required';
            $rules['email'] = 'required|email|unique:users,email';
        }
        else{
            $rules['email'] = 'required|email|unique:users,email,'.$this->cur_id;
        }
        $this->validate($rules);
        if($this->cur_id){
            $usr = User::find($this->cur_id);
        }
        else{
            $usr = new User();
        }
        $role = Role::where('name', 'user')->first();
        $usr->role_id = $role->id;
        $usr->name = $this->name;
        $usr->surname = $this->surname;
        $usr->mobile_number = $this->mobile_number;
        $usr->email = $this->email;
        if($this->password){
            $usr->password = Hash::make($this->password);
        }
        $usr->save();
        $this->clearFields();
        $this->dispatch('close-modal');
    }

    public function render(){
        $key = $this->search_key;

        $users = User::query()
        ->when($key, function($q) use($key){
            return $q->where('name', 'LIKE', '%'.$key.'%')
            ->orWhere('surname', 'LIKE', '%'.$key.'%')
            ->orWhere('mobile_number', 'LIKE', '%'.$key.'%')
            ->orWhere('email', 'LIKE', '%'.$key.'%');
        })
        ->whereDoesntHave('role', function($q){
            return $q->where('name', 'admin');
        })
        ->orderBy('name', 'ASC')
        ->paginate(12);

        return view('livewire.account.admin.list-users', [
            'users' => $users
        ]);
    }
}

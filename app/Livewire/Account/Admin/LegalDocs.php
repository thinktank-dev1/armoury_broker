<?php

namespace App\Livewire\Account\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\LegalDoc;

class LegalDocs extends Component
{
    use WithFileUploads;

    // public $terms_of_use, $privacy_policy;
    public $cur_type;
    public $file;

    public function clearFields(){
        $this->cur_type = null;
        $this->file = null;
    }

    public function showModal($type){
        $this->cur_type = $type;
        $this->dispatch('show-modal');
    }

    public function saveDoc(){
        $this->validate([
            'cur_type' => 'required',
            'file' => 'required|file',
        ]);
        $file_name = null;
        if($this->file){
            $file_name = $this->file->storePublicly('legal', 'public');
        }
        if($file_name){
            $doc = LegalDoc::where('name', $this->cur_type)->first();
            if(!$doc){
                $doc = new LegalDoc();
            }
            $doc->name = $this->cur_type; 
            $doc->link_url = $file_name;
            $doc->save();

            $this->dispatch('close-modal');
            $this->clearFields();
        }

    }

    public function render(){
        $docs = LegalDoc::get();
        return view('livewire.account.admin.legal-docs', [
            'docs' => $docs
        ]);
    }
}

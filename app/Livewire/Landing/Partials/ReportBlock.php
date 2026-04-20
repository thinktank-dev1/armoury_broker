<?php

namespace App\Livewire\Landing\Partials;

use Livewire\Component;
use Livewire\Attributes\On; 

use Auth;
use App\Models\Vendor;
use App\Models\VendorReports;
use App\Models\BlockVendor;

class ReportBlock extends Component
{
    public $vendor;
    public $description;
    public $is_blocked;

    public function mount($vendor_id){
        $this->vendor = Vendor::find($vendor_id);
    }

    public function toggleBlock(){
        $vendor_id = $this->vendor->id;
        if(!Auth::guest()){
            $blk = BlockVendor::where('user_id', Auth::user()->id)->where('vendor_id', $vendor_id)->first();
            if(!$blk){
                $blk = new BlockVendor();

                $blk->user_id = Auth::user()->id;
                $blk->vendor_id = $vendor_id;
                $blk->save();
            }
            else{
                $blk->delete();
            }
        }
    } 

    public function reportVendor(){
        $this->validate([
            'description' => 'required'
        ]);
        $rep = new VendorReports();
        $rep->vendor_id = $this->vendor->id;
        if(!Auth::guest()){
            $rep->user_id = Auth::user()->id;
        }
        $rep->description = $this->description;
        $rep->status = 0;
        $rep->save();

        $this->dispatch('report-sent');
    }

    public function render(){
        $this->is_blocked = false;
        if(!Auth::guest()){
            $blk = BlockVendor::where('user_id', Auth::user()->id)->where('vendor_id', $this->vendor->id)->first();
            if($blk){
                $this->is_blocked = true;
            }
        }

        return view('livewire.landing.partials.report-block');
    }
}

<?php

namespace App\Livewire\Account\Admin\Dealers;

use Livewire\Component;

use Auth;
use App\Models\Dealer;
use App\Models\Vendor;
use App\Models\OrderItem;

use App\Lib\Communication;

class ViewDealer extends Component
{
    public $cur_id;

    public function mount($id){
        $this->cur_id = $id;
    }

    public function changeStatus($status){
        $dl = Dealer::find($this->cur_id);
        if($dl){
            $dl->status = $status;
            $dl->save();
        }

        if($status == 1){
            $comm = new Communication();
            $body = "
            Congratulations<br /><br />
            We are pleased to inform you that your dealer application has been approved, and you are now officially registered as a dealer on our platform.<br />
            As a dealer, if you are selected by other users to stock products on their behalf, you will receive a fee for providing this stocking service. Further details regarding stocking will be communicated to you by the respective parties.<br />
            Should you wish to cancel, you can do so in the settings section of your account<br /><br />
            We’re excited to have you on board and look forward to working with you. Should you have any questions, please don’t hesitate to reach out.<br /><br />
            Kind regards,
            ";

            $dl = Dealer::find($this->cur_id);
            $data = [
                'to' => $dl->user->email,
                'name' => $dl->user->name,
                'subject' => 'Dealer Approval Confirmation',
                'title' => "Dealer Approval Confirmation",
                'message_body' => $body,
                'cta' => false,
                'cta_text' => null,
                'cta_url' => null,
                'after_cta_body' => null,
            ];
            $comm->sendMail($data);
        }
    }

    public function render(){
        $dealer = Dealer::find($this->cur_id);
        $vendor = null;
        if($dealer->user){
            $vendor = Vendor::find($dealer->user->vendor_id);
        }

        $sels = OrderItem::where('dealer_option', 'ab dealer')->where('ab_dealer_id', $this->cur_id)->get();

        return view('livewire.account.admin.dealers.view-dealer', [
            "vendor" => $vendor,
            "dealer" => $dealer,
            "sels" => $sels,
        ]);
    }
}

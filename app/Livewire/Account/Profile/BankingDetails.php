<?php

namespace App\Livewire\Account\Profile;

use Livewire\Component;

use App\Lib\Communication;

use Auth;
use App\Models\BankDetail;

class BankingDetails extends Component
{
    public $bank_name, $branch_code, $account_number, $branch_name, $account_holder;

    public function mount(){
        $det = BankDetail::where('user_id', Auth::user()->id)->first();
        if($det){
            $this->bank_name = $det->bank_name;
            $this->branch_code = $det->branch_code;
            $this->account_number = $det->account_number;
            $this->branch_name = $det->branch_name;
            $this->account_holder = $det->account_holder;
        }
    } 

    public function saveBankDetails(){
        $this->validate([
            'bank_name' => 'required', 
            'branch_code' => 'required', 
            'account_number' => 'required', 
            'branch_name' => 'required', 
            'account_holder' => 'required'
        ]);
        $det = BankDetail::where('user_id', Auth::user()->id)->first();
        if(!$det){
            $det = new BankDetail();
        }
        $det->user_id = Auth::user()->id;
        $det->bank_name = $this->bank_name;
        $det->branch_code = $this->branch_code;
        $det->account_number = $this->account_number;
        $det->branch_name = $this->branch_name;
        $det->account_holder = $this->account_holder;
        $det->save();

        $body = "Your banking details were recently changed on your account.<br /><br />
        If you made this change, no further action is needed.<br />
        If you did not make this change, please:<br />
        <ul>
            <li>Secure your account immediately by resetting your password.</li>
            <li>Contact our support team at support@armourybroker.co.za.</li>
        </ul>
        Your account security is our top priority.";

        $user = Auth::user();
        $data = [
            'to' => $user->email,
            'name' => $user->name,
            'subject' => 'Banking details updated',
            'title' => "Banking details updated",
            'message_body' => $body,
            'cta' => false,
            'cta_text' => null,
            'cta_url' => null,
            'after_cta_body' => null,
        ];
        $comm = new Communication();
        $comm->sendMail($data);

        session()->flash('status', 'Banking details successfully updated.');

    }

    public function render(){
        return view('livewire.account.profile.banking-details');
    }
}

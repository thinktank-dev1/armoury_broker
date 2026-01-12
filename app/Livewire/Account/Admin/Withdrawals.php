<?php

namespace App\Livewire\Account\Admin;

use Livewire\Component;

use App\Lib\Communication;

use App\Models\WithdrawalRequest;
use App\Models\Transaction;

use App\Exports\PaymentExport;
use Maatwebsite\Excel\Facades\Excel;

class Withdrawals extends Component
{
    public function exportWithdrawals(){
        return Excel::download(new PaymentExport, 'withdrawals.xlsx');
    }

    public function setPaid($id){
        $req = WithdrawalRequest::find($id);
        if($req){
            $req->status = 1;
            $req->save();

            $trx = Transaction::create([
                'name' => 'withdrawal',
                'transaction_type' => 'withdrawal',
                'user_id' => $req->vendor->user->id,
                'vendor_id' => $req->vendor_id,
                'direction' => 'out',
                'amount' => $req->amount,
                'payment_status' => 'COMPLETE',
                'release' => 1,
            ]);

            $comm = new Communication();
            $data = [
                'name' => $req->vendor->user->name,
                'to' => $req->vendor->user->email,
                'subject' => 'Armoury Broker Withdrawal Complete',
                'title' => 'Armoury Broker Withdrawal Complete',
                'message_body' => "
                    <b>Your withdrawal request has been completed</b><br />
                    Amount: R".number_format($req->amount)."<br /><br />
                ",
                "cta" => false,
                "after_cta_body" => null,
            ];
            $comm->sendMail($data);
        }
    }

    public function render(){
        $requests = WithdrawalRequest::where('verified', 1)->where('status', 0)->get();
        return view('livewire.account.admin.withdrawals', [
            'requests' => $requests
        ]);
    }
}

<?php

namespace App\Livewire\Account;

use Livewire\Component;
use Livewire\WithPagination;

use App\Lib\Communication;

use Auth;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\WithdrawalRequest;

class Vault extends Component
{
    use WithPagination;

    public $amount, $bank_name, $branch_name, $branch_code, $account_name, $account_number;

    public function requestWithdrawal(){
        $this->validate([
            'amount' => 'required|numeric', 
            'bank_name' => 'required', 
            'branch_name' => 'required', 
            'branch_code' => 'required', 
            'account_name' => 'required', 
            'account_number' => 'required'
        ],[
            'amount.numeric'=>"Amount must be a number"
        ]);

        $trx_in = Transaction::where('vendor_id', Auth::user()->vendor_id)->where('direction', 'in')->sum('amount');
        $trx_out = Transaction::where('vendor_id', Auth::user()->vendor_id)->where('direction', 'out')->sum('amount');
        $balance = $trx_in - $trx_out;

        if($this->amount > $balance){
            $this->addError('error', "Insufficient balance");
        }
        else{
            $wd = WithdrawalRequest::create([
                'vendor_id' => Auth::user()->vendor_id,
                'amount' => $this->amount, 
                'bank_name' => $this->bank_name, 
                'branch_name' => $this->branch_name, 
                'branch_code' => $this->branch_code, 
                'account_name' => $this->account_name, 
                'account_number' => $this->account_number,
            ]);

            $comm = new Communication();
            $data = [
                'name' => Auth::user()->name,
                'to' => Auth::user()->email,
                'subject' => 'Armoury Broker Withdrawal Request',
                'message_body' => "
                    <b>You requested a withdrawal</b><br />
                    Amount: R".number_format($this->amount)."<br /><br />
                    <a href='".url('approve-withdrawal/'.$wd->id)."'>Click here to approve</a><br /><br />
                    If this was not you, no further action is required, we do however encourage you to change your password on <a href='".url('login')."'>Armoury Broker</a>
                "
            ];

            $comm->sendMail($data);
            session()->flash('status', 'Please check you email for withdrawal verification.');
        }
    }

    public function render(){
        $items_sold = OrderItem::query()
        ->where('vendor_id', Auth::user()->vendor_id)
        ->whereHas('order', function($q){
            return $q->where('status', 'COMPLETE');
        })
        ->count();

        $tot_sales = Transaction::where('vendor_id', Auth::user()->vendor_id)->sum('amount');

        $tot_withdrawals = Transaction::where('transaction_type', 'withdrawal')->where('vendor_id', Auth::user()->vendor_id)->sum('amount');

        $trx_in = Transaction::where('vendor_id', Auth::user()->vendor_id)->where('direction', 'in')->sum('amount');
        $trx_out = Transaction::where('vendor_id', Auth::user()->vendor_id)->where('direction', 'out')->sum('amount');
        $balance = $trx_in - $trx_out;

        $trxs = Transaction::where('vendor_id', Auth::user()->vendor_id)->orderBy('created_at', 'DESC')->paginate(12);

        return view('livewire.account.vault', [
            'items_sold' => $items_sold,
            'tot_sales' => $tot_sales,
            'tot_withdrawals' => $tot_withdrawals,
            'balance' => $balance,
            'trxs' => $trxs
        ]);
    }
}

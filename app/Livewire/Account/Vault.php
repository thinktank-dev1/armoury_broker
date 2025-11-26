<?php

namespace App\Livewire\Account;

use Livewire\Component;
use Livewire\WithPagination;

use App\Lib\Communication;

use Auth;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\WithdrawalRequest;
use App\Models\BankDetail;

class Vault extends Component
{
    use WithPagination;

    public $amount, $bank_name, $branch_name, $branch_code, $account_name, $account_number;

    public $filter, $date_from, $date_to;

    public $withdrawable_balance, $orders_in_progress, $gift_voucher_balance, $spendable_amount, $ab_credit, $tot_credit;
    public $tot_purchases, $tot_sales,$in_progress_orders;

    public function mount(){
        $this->getData();

        $bnk = BankDetail::where('user_id', Auth::user()->id)->first();
        if($bnk){
            $this->bank_name = $bnk->bank_name;
            $this->branch_name = $bnk->branch_name;
            $this->branch_code = $bnk->branch_code;
            $this->account_name = $bnk->account_holder;
            $this->account_number = $bnk->account_number;
        }
    }

    public function getData(){
        $this->ab_credit = 0;
        $this->withdrawable_balance = Auth::user()->vendor->withdrawableBalance();
        $this->gift_voucher_balance = Auth::user()->vendor->giftVoucherBalance();
        $this->spendable_amount = $this->withdrawable_balance + $this->gift_voucher_balance;
        $this->orders_in_progress = Transaction::where('name', 'order_payment')->where('vendor_id', Auth::user()->vendor_id)->whereNull('release')->whereNull('canceled')->sum('amount');
        
        $this->tot_credit = $this->ab_credit + $this->withdrawable_balance + $this->gift_voucher_balance + $this->orders_in_progress;

        $this->tot_purchases = 0;
        $prs = OrderItem::where('user_id', Auth::user()->id)->wherehas('order', function($q){
            return $q->whereNotNull('g_payment_id');
        })
        ->where('vendor_status', '<>', 'Canceled')
        ->get();
        foreach($prs AS $pr){
            $this->tot_purchases += ($pr->price * $pr->quantity);
        }

        $this->tot_sales = 0;
        $ords = OrderItem::where('vendor_id', Auth::user()->vendor_id)->wherehas('order', function($q){
            return $q->whereNotNull('g_payment_id');
        })
        ->where('vendor_status', '<>', 'Canceled')
        ->get();
        foreach($ords AS $ord){
            $this->tot_sales += ($ord->price * $ord->quantity);
        }

        $this->in_progress_orders = OrderItem::query()
        ->where('vendor_id', Auth::user()->vendor_id)
        ->whereNotNull('order_id')
        ->whereHas('order', function($q){
            return $q->whereNotNull('g_payment_id');
        })
        ->where(function($q){
            return $q->where(function($qq){
                return $qq->whereNull('vendor_status')
                ->whereNotNull('buyer_status');
            })
            ->orWhere(function($qq){
                return $qq->whereNotNull('vendor_status')
                ->where('vendor_status', '<>', 'Canceled')
                ->whereNull('buyer_status');
            });
        })
        ->sum('price');
    }

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

        $balance = Auth::user()->vendor->withdrawableBalance();

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
                'title' => 'Armoury Broker Withdrawal Request',
                'subject' => 'Armoury Broker Withdrawal Request',
                'message_body' => "
                    You requested a withdrawal<br /><br />
                    Amount: R".number_format($this->amount)."<br /><br />
                ",
                'cta' => true,
                'cta_text' => 'Click here to approve',
                'cta_url' => url('approve-withdrawal/'.$wd->id),
                'after_cta_body' => "If this was not you, no further action is required, we do however encourage you to change your password on <a href='".url('login')."'>Armoury Broker</a>",
            ];

            $comm->sendMail($data);
            session()->flash('status', 'Please check you email for withdrawal verification.');
        }
    }

    public function changeFilter($f){
        $this->filter = $f;
    }

    public function render(){
        $items_sold = OrderItem::query()
        ->where('vendor_id', Auth::user()->vendor_id)
        ->whereHas('order', function($q){
            return $q->where('status', 'COMPLETE');
        })
        ->count();

        $tot_sales = Transaction::where('vendor_id', Auth::user()->vendor_id)->where('transaction_type', '<>', 'voucher_balance')->sum('amount');

        $tot_withdrawals = Transaction::where('transaction_type', 'withdrawal')->where('vendor_id', Auth::user()->vendor_id)->sum('amount');

        $filter = $this->filter; 
        $date_from = $this->date_from;
        $date_to = $this->date_to;

        $trxs = Transaction::query()
        ->where(function ($q) {
            $q->where('user_id', Auth::user()->id)
            ->orWhere('vendor_id', Auth::user()->vendor_id);
        })
        ->when($date_from, function($q) use($date_from){
            return $q->whereDate('created_at', '>', $date_from);
        })
        ->when($date_to, function($q) use($date_to){
            return $q->whereDate('created_at', '<', $date_to);
        })
        ->when($filter, function($q) use($filter){
            if($filter == "orders"){
                return $q->where('vendor_id', Auth::user()->vendor_id);
            }
            if($filter == "purchases"){
                return $q->where('user_id', Auth::user()->id);
            }
            if($filter == "refunds"){
                return $q->where('transaction_type', 'refund');
            }
            if($filter == "complete"){
                return $q->where('payment_status', 'COMPLETE');
            }
            if($filter == "pending"){
                return $q->where('payment_status','<>', 'COMPLETE');
            }
        })
        ->orderBy('created_at', 'DESC')
        ->paginate(12);

        return view('livewire.account.vault', [
            'items_sold' => $items_sold,
            'tot_sales' => $tot_sales,
            'tot_withdrawals' => $tot_withdrawals,
            'trxs' => $trxs
        ]);
    }
}

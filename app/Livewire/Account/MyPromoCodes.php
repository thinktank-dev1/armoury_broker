<?php

namespace App\Livewire\Account;

use Livewire\Component;

use App\Lib\PayFastApi;

use Auth;
use App\Models\PromoCode;
use App\Models\Transaction;

class MyPromoCodes extends Component
{
    public $amount;
    public $payment_url;

    public function mount(){
        $this->payment_url = env('PAYFAST_SANDBOX_URL');
    }

    public function createPromoCode($wallet = null){
        $this->validate([
            'amount' => 'required'
        ]);

        $code = null;
        while(!$code){
            $code = $this->genCode();
        }

        if($wallet){
            $bal = Auth::user()->vendor->balance();
            if($this->amount > $bal){
                $this->addError('error', 'Insufficient balance in wallet');
                return;
            }

            $pr = PromoCode::create([
                'user_id' => Auth::user()->id,
                'code' => $code,
                'amount' => $this->amount,
                'payment_type' => 'wallet',
                'payment_reff' => $code,
                'payment_status' => 'COMPLETE',
            ]);
            $trx = Transaction::create([
                'transaction_type' => 'promo_code_purchase',
                'user_id' => Auth::user()->id,
                'vendor_id' => Auth::user()->vendor->id,
                'direction' => 'out',
                'amount' => $this->amount,
                'payment_status' => 'COMPLETE',
            ]);
            session()->flash('status', 'Purchase successfully completed.');
            $this->amount = null;
        }
        else{
            $pr = PromoCode::create([
                'user_id' => Auth::user()->id,
                'code' => $code,
                'amount' => $this->amount,
            ]);

            $data = [
                'user_first_name' => Auth::user()->name,
                'user_last_name' => Auth::user()->surname,
                'user_email' => Auth::user()->email,
                'user_cell_number' => Auth::user()->mobile_number,
                'payment_id' => $pr->id,
                'amount' => $this->amount,
            ];

            $pf = new PayFastApi();
            $payload = $pf->setPromoPayLoad($data);
            $payload = json_encode($payload);
            $this->dispatch('process-payment', data: $payload);
        }
    }

    public function genCode(){
        $digits = 4;
        while(true){
            $min = pow(10, $digits - 1);
            $max = pow(10, $digits) - 1;

            $count = PromoCode::whereBetween('code', [$min, $max])->count();
            if($count >= ($max - $min + 1)){
                $digits++;
                continue;
            }

            do{
                $num = (string)rand($min, $max);
                $exists = PromoCode::where('code', $num)->exists();
            }while ($exists);

            return $num;
        }
    }

    public function render(){
        $codes = PromoCode::where('user_id', Auth::user()->id)->where('payment_status', 'COMPLETE')->orderBy('status', 'ASC')->orderBy('created_at', 'DESC')->get();
        return view('livewire.account.my-promo-codes', [
            'codes' => $codes
        ]);
    }
}

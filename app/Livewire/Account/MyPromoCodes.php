<?php

namespace App\Livewire\Account;

use Livewire\Component;

use App\Lib\PayFastApi;

use Auth;
use App\Models\PromoCode;
use App\Models\Transaction;
use App\Models\VendorPromoCode;

class MyPromoCodes extends Component
{
    public $amount;
    public $payment_url;

    public $code_type, $vendor_promo_code_value, $name, $vendor_promo_code, $start_date, $end_date, $start_time, $end_time;

    public function mount(){
        $this->payment_url = env('PAYFAST_SANDBOX_URL');
    }

    public function changeType($t){
        $this->code_type = $t;
    }

    public function changeStatus($id,$status){
        $cd = VendorPromoCode::find($id);
        if($cd){
            $cd->status = $status;
            $cd->save();
        }
    }

    public function deleteCode($id){
        $cd = VendorPromoCode::find($id);
        if($cd){
            $cd->deleted = 1;
            $cd->save();
        }
    }

    public function createVendorPromoCode(){
        $this->validate([
            'code_type' => 'required', 
            'vendor_promo_code_value' => 'required', 
            'name' => 'required', 
            'vendor_promo_code' => 'required'
        ]);
        $go = True;
        $fnd = VendorPromoCode::where('code', $this->vendor_promo_code)->first();
        if($fnd){
            $go = false;
            $this->addError('error', "Code has already been used, please try a different one");
        }
        if($go){
            VendorPromoCode::create([
                'vendor_id' => Auth::user()->vendor_id,
                'description' => $this->name,
                'code' => $this->vendor_promo_code,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'type' => $this->code_type,
                'value' => $this->vendor_promo_code_value,
            ]);
            session()->flash('status', 'Purchase successfully completed.');
        }
    }

    public function generateCode(){
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $cnt = 0;
        $length = 6;
        while(true){
            $cnt += 1;
            $str = '';
            for ($i = 0; $i < $length; $i++) {
                $str .= $chars[rand(0, strlen($chars) - 1)];
            }
            $cd = VendorPromoCode::where('code', $str)->first();
            if(!$cd){
                $this->vendor_promo_code = strtoupper($str);
                break;
            }
            if($cnt == 0){
                $cnt = 0;
                $length += 1;
            }
        }
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
        
        $v_codes_active = VendorPromoCode::where('vendor_id', Auth::user()->vendor_id)->where('deleted', 0)->where('status', 1)->get();
        $v_codes_inactive = VendorPromoCode::where('vendor_id', Auth::user()->vendor_id)->where('deleted', 0)->where('status', 0)->get();
        
        return view('livewire.account.my-promo-codes', [
            'v_codes_active' => $v_codes_active,
            'v_codes_inactive' => $v_codes_inactive
        ]);
    }
}

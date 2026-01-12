<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use App\Models\WithdrawalRequest;

class PaymentExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return WithdrawalRequest::where('status', 0)->where('verified', 1)->with('vendor')->get();
    }
}

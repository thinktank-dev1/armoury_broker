<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\WithdrawalRequest;

class PaymentExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return WithdrawalRequest::where('status', 0)
        ->where('verified', 1)
        ->with('vendor')
        ->get()
        ->map(function ($item) {
            return [
                'ID' => $item->id,
                'Vendor ID' => $item->vendor_id,
                'Amount' => $item->amount,
                'Bank Name' => $item->bank_name,
                'Branch' => $item->branch_name,
                'Branch Code' => $item->branch_code,
                'Account Name' =>$item->account_name,
                'Account Number' => $item->account_number,
                'Vendor' => optional($item->vendor)->name,
                'Vendor Email' => optional($item->vendor->user)->email,
                'Date' => $item->created_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            '#',
            'Vendor ID',
            'Amount',
            'Bank Name',
            'Branch',
            'Branch Code',
            'Account Name',
            'Account Number',
            'Vendor',
            'Email',
            'Date',
        ];
    }
}

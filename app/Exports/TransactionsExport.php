<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;

class TransactionsExport implements FromArray
{
    
    public $data;
    public function __construct($data){
        $this->data = $data;
    }


    public function array(): array
    {
        return $this->data;
    }
}

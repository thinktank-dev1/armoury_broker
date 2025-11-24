<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

use App\Models\Caliber;

class CaliberImport implements ToModel
{
    public function model(array $row)
    {
        return new Caliber([
           'caliber'     => $row[0]
        ]);
    }
}

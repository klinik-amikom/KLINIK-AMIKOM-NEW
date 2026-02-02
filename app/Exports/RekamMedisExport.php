<?php

namespace App\Exports;

use App\Models\RekamMedis;
use Maatwebsite\Excel\Concerns\FromCollection;

class RekamMedisExport implements FromCollection
{
    public function collection()
    {
        return RekamMedis::all();
    }
}
<?php

namespace App\Exports;

use App\Models\Fasilitas;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class FasilitasExport implements FromQuery
{
    use Exportable;

    public function query()
    {
        return Fasilitas::query();
    }
}

<?php

namespace App\Exports;

use App\Models\Kavling;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class KavlingExport implements FromQuery
{
    use Exportable;

    public function query()
    {
        return Kavling::query();
    }
}

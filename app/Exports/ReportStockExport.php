<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportStockExport implements FromView
{
    public $data;

    function __construct($data)
    {   
        $this->data = $data;
    }

    public function view(): View
    {
        return view('pdf.report_stock_excel', $this->data);
    }
}

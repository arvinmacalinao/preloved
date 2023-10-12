<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductsExport implements FromView, WithColumnWidths, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $collection;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    public function view(): View
    {
        return view('excel.products', ['collection' => $this->collection]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 33, 
            'C' => 15,           
            'D' => 15,           
            'E' => 15,           
            'F' => 15,           
            'G' => 15,           
            'H' => 15,                                   
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'C' => ['alignment' => ['wrapText' => true]],
            'E' => ['alignment' => ['wrapText' => true]],
            'F' => ['alignment' => ['wrapText' => true]],
            'G' => ['alignment' => ['wrapText' => true]],
            'H' => ['alignment' => ['wrapText' => true]],
        ];
    }
}

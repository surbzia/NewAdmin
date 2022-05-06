<?php
namespace App\Exports;

use App\Models\Brand;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BrandsExportXLXS implements FromQuery, WithHeadings
{
    use Exportable;

    private $writerType = Excel::XLSX;

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Slug',
            'Image',
        ];
    }

    public function query()
    {
        return Brand::query()->select('id','name','slug');
    }
}
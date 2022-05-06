<?php
namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CategoryExportXLXS implements FromQuery, WithHeadings
{
    use Exportable;

    private $writerType = Excel::XLSX;

    public function headings(): array
    {
        return [
            '#',
            'Parent ID',
            'Name',
            'Slug',
            'Image',
        ];
    }

    // public function collection()
    // {
    //     return Category::select('id','parent_id','name','slug')->get();
    // }
    public function query()
    {
        return Category::query()->select('id','parent_id','name','slug')->without([
            'image','children'
        ]);
    }
}
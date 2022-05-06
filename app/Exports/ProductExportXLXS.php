<?php
namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductExportXLXS implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    private $writerType = Excel::XLSX;

    public function headings(): array
    {
        return [
            'Product ID',
            'SKU',
            'Part Number',
            'Condition',
            'Currency',
            'Price',
            'Sale Price',
            'Manufacturer',
            'Category',
            'Title',
            'Product URL',
            'Image URL',
            'Weight',
            'Availability',
            'Remain Stock',
            'Description',
            'Supplier',
            'Supplier URL',
            'Google Feed',
            'Active',
        ];
    }

    public function query()
    {
        return Product::query();
    }
    public function map($product): array
    {
        return [
            $product->id,
            $product->sku,
            $product->part_number,
            $product->condition,
            'US',
            $product->price,
            $product->sale_price,
            $product->brand->id.' | '.$product->brand->name,
            $product->category->id.' | '.$product->category->name,
            $product->name,
            env('MIX_FRONT_WEBSITE_URL').'/product/'.$product->slug,
            $product->image_url,
            $product->weight,
            ($product->in_stock==1?'Instock':'Outofstock'),
            $product->stock_qty,
            $product->description,
            $product->crawl_site,
            $product->crawl_url,
            $product->google_feed,
            $product->is_active,
        ];
    }
}
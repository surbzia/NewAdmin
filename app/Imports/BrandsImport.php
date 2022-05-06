<?php

namespace App\Imports;

use App\Models\Brand;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class BrandsImport implements ToModel, WithChunkReading, ShouldQueue
{
    /**
     * @param array $row
     *
     * @return Brand|null
     */
    public function model(array $row)
    {
        return new Brand([
           'name'     => $row[0],
           'slug'    => Str::slug($row[0],'-'),
        ]);
    }
    public function chunkSize(): int
    {
        return 50;
    }
}
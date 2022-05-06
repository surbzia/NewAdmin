<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
//use Excel;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BrandsExportXLXS;
use App\Models\{User};
use App\Notifications\ExportBrands as ExportBrandsNotification;
class ExportBrands implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $filename = 'brands'.time().'.xlsx';
        $path = public_path('storage/brand_exports/'.$filename);
        if(!file_exists(public_path('storage/brand_exports'))){
            mkdir(public_path('storage/brand_exports'));
        }
        if(!file_exists($path)){
            $myfile = fopen($path, "w");
            fclose($myfile);
        }
        // $filename = 'brands.xlsx';
        Excel::store(new BrandsExportXLXS, $path);//$filename);
        $this->user->notify(new ExportBrandsNotification(['file'=>asset('brand_exports/'.$filename)]));
    }
}

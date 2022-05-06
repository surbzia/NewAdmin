<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Exports\CategoryExportXLXS;
use App\Models\{User};
use App\Notifications\ExportCategory as ExportCategoryNotification;
use Excel;

class ExportCategory implements ShouldQueue
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
        $filename = 'category'.time().'.xlsx';
        $path = public_path('storage/category_exports/'.$filename);
        if(!file_exists(public_path('storage/category_exports'))){
            mkdir(public_path('storage/category_exports'));
        }
        if(!file_exists($path)){
            $myfile = fopen($path, "w");
            fclose($myfile);
        }
        // $filename = 'brands.xlsx';
        Excel::store(new CategoryExportXLXS, $path);//$filename);
        $this->user->notify(new ExportCategoryNotification(['file'=>asset('category_exports/'.$filename)]));
    }
}

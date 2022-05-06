<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\{File, Product, Brand, User};
use Illuminate\Support\Str;
use App\Notifications\ProductImports;

class ImportProductsSheet implements ShouldQueue, ShouldBeUniqueUntilProcessing
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $user;
    protected $file;
    public function __construct(File $file, User $user)
    {
        $this->file = $file;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $filename = public_path('storage/'.$this->file->url);
        if (!file_exists($filename) || !is_readable($filename)){
            return false;
        }
        if (($handle = fopen($filename, 'r')) !== false)
        {
            $count = 0;
            while(! feof($handle)){
                $count++;
                $row = fgetcsv($handle);
                if($count>1){
                    list($sku, $part,$condition,$currency,$price,$saleprice,$manufacturer_id,$category_id,$name,$image_url,$weight,$availability,$remaining_stock,$specification,$crawl_site,$url, $google_feed,$is_active) = $row;
                    // if($part)
                    {
                        $saleprice = str_replace('$','',$saleprice);
                        $price = str_replace('$','',$price);
                        $in_stock = Str::contains(strtolower($availability), 'instock');
                        if($sku){
                            if(Product::where('sku',$sku)->count()>0){
                                $updatedArray = [];
                                if($part){
                                    $updatedArray['part_number'] = $part;
                                }
                                if($name){
                                    $updatedArray['name'] = $name;
                                }
                                if($manufacturer_id){
                                    $updatedArray['brand_id'] = $manufacturer_id;
                                }
                                if($category_id){
                                    $updatedArray['category_id'] = $category_id;
                                }
                                if($condition){
                                    $updatedArray['condition'] = $condition;
                                }
                                if($saleprice){
                                    $updatedArray['sale_price'] = $saleprice;
                                }
                                if($weight){
                                    $updatedArray['weight'] = $weight;
                                }
                                if($price){
                                    $updatedArray['price'] = $price;
                                }
                                if($url){
                                    $updatedArray['crawl_url'] = $url;
                                }
                                if($specification){
                                    $updatedArray['description'] = $specification;
                                }
                                if($in_stock){
                                    $updatedArray['in_stock'] = $in_stock;
                                }
                                if(intval($remaining_stock)){
                                    $updatedArray['stock_qty'] = intval($remaining_stock);
                                    $updatedArray['manage_stock'] = (intval($remaining_stock)>0?1:0);
                                }
                                if($crawl_site){
                                    $updatedArray['crawl_site'] = $crawl_site;
                                }
                                if($google_feed){
                                    $updatedArray['google_feed'] = $google_feed;
                                }
                                if($is_active){
                                    $updatedArray['is_active'] = $is_active;
                                }
                                // $product = Product::where('sku',$sku)->update(
                                //     [
                                //         'part_number'=>$part,'name'=>$name,'brand_id'=>$manufacturer_id,
                                //         'category_id'=>$category_id,'condition'=>$condition,'sale_price'=>$saleprice,
                                //         'weight'=>$weight,'price'=>$price,
                                //         'crawl_url'=>$url,'description'=>$specification,
                                //         'in_stock'=>$in_stock,'stock_qty'=>intval($remaining_stock),'manage_stock'=>(intval($remaining_stock)>0?1:0),
                                //         'crawl_site'=>$crawl_site,
                                //         'google_feed'=>$google_feed,
                                //         'is_active'=>$is_active,
                                //     ]
                                // );
                                $product = Product::where('sku',$sku)->update($updatedArray);
                            }
                        }else{
                            if($part&&$name&&$manufacturer_id&&$category_id&&$condition&&$saleprice&&$price){
                                //checking if part number and condition exists from earliar
                                if(Product::where('part_number',$part)->where('condition',$condition)->count()==0){
                                    $product = Product::create(
                                        [
                                            'part_number'=>$part,'name'=>$name,'brand_id'=>$manufacturer_id,
                                            'category_id'=>$category_id,'condition'=>$condition,'sale_price'=>$saleprice,
                                            'weight'=>$weight,'price'=>$price,
                                            'crawl_url'=>$url,'description'=>$specification,
                                            'in_stock'=>$in_stock,'stock_qty'=>intval($remaining_stock),'manage_stock'=>(intval($remaining_stock)>0?1:0),
                                            'crawl_site'=>$crawl_site,
                                            'slug'=>Str::slug($part).$count,
                                            'google_feed'=>$google_feed,
                                            'is_active'=>$is_active,
                                        ]
                                    );
                                    $product->sku = 'CRIS-'.$product->id;
                                    $product->save();
                                }
                            }
                        }
                    }
                }
            }
            fclose($handle);
        }
        $this->user->notify(new ProductImports(['file'=>$this->file->full_url]));
    }
}

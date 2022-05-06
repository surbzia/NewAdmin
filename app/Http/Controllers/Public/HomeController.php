<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Product, Category, Banner, OrderProduct};
use DB;
class HomeController extends Controller
{
    public function index(){
        $banners = Banner::orderBy('id','desc')->get();
        $categories = Category::orderBy('id','desc')->where('is_featured',1)->get();
        $featured_products = Product::orderBy('id','desc')->where('is_featured',1)->get();
        $most_selling_products = OrderProduct::orderByRaw(DB::raw("COUNT(*) DESC"))->limit(9)
        ->select(DB::raw("COUNT(*) AS order_count"),"product_id"
        // ,'products.*'
        )
        // ->rightJoin('products', 'products.id', '=', 'order_products.product_id')
        ->groupBy('product_id')->get();
        $most_selling_products->load('product');
        return response()->json(['banners'=>$banners,'categories'=>$categories,'featured_products'=>$featured_products,'most_selling_products'=>$most_selling_products]);
    }
    public function menu(){
        $mainMenuCategories = Category::without(['image','parent','children'])
        ->select('name','category_alias','slug','id')->where('show_in_main_menu',1)->get();
        $SideMenuCategories = Category::without(['image','parent'])
        ->select('name','category_alias','slug','id')->where('show_in_home_sidemenu',1)
        ->where('parent_id',0)->get();
        return response()->json([
            'mainmenu'=>$mainMenuCategories,
            'sidemenu'=>$SideMenuCategories,
        ]);
    }
}

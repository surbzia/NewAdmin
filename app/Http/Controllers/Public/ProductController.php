<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\{ProductQuoteRequest, QuoteFormRequest};
use App\Models\{Product, Category, ProductQuote, Brand, QuoteForm};
class ProductController extends Controller
{
    public function categories(){
        $categories = Category::orderBy('id','desc');
        if(isset($_GET['featured'])){
            $categories = $categories->where('is_featured',1);
        }
        if(isset($_GET['perpage'])&&intval($_GET['perpage'])>0){
            $categories = $categories->paginate(18);
        }else{
            $categories=$categories->get();
        }
        return response()->json(['categories'=>$categories]);
    }
    public static function childs($category, $arr = []){
        $arr[] = $category->id;
        foreach($category->children as $child){
            $arr = self::childs($child, $arr);
        }
        return $arr;
    }
    public function getViaSlug(Request $request){
        $category = Category::where('slug',$request->slug)->first();
        $prducts = Product::query();
        $products =  $prducts->orderBy($request->sortBy,$request->orderBy);
        $ids = $this->childs($category);
        $products = $products->whereIn('category_id',$ids);
        $brands = Brand::whereIn('id',Product::whereIn('category_id',$ids)
        ->select('brand_id')->distinct()->get()->pluck('brand_id'))
        ->withCount('products')->get();
        $products=$products->paginate(16);
        $parents = ($this->getParents($category));
        $parents = array_reverse($parents);
        return response()->json(['products'=>$products,'parents'=>$parents,'brands'=>$brands,'category'=>$category]);
    }
    public function index(){
        $products = Product::orderBy('id','desc');
        if(isset($_GET['featured'])){
            $products = $products->where('is_featured',1);
        }
        if(isset($_GET['category_id'])&&intval($_GET['category_id'])>0){
            $products = $products->where('category_id',intval($_GET['category_id']));
        }
        if(isset($_GET['perpage'])&&intval($_GET['perpage'])>0){
            $products = $products->paginate(18);
        }else{
            $products=$products->get();
        }
        return response()->json(['products'=>$products]);
    }
    public function get($slug){
        $product = Product::where('slug',$slug)->with('related')->firstOrfail();
        $parents = ($this->getParents($product->category));
        $parents = array_reverse($parents);
        $product->load('brand');
        return response()->json(['product'=>$product,'parents'=>$parents]);
    }
    public function category(Category $category){
        return response()->json(['category'=>$category]);
    }
    public function quote(ProductQuoteRequest $request){
        $quote = ProductQuote::create($request->only('email','qty','product_id','message'));
        return response()->json(['quote'=>$quote]);
    }
    public function quoteform(QuoteFormRequest $request){
        $quote = QuoteForm::create($request->only(
            'name',
            'email',
            'description',
            'condition',
            'quantity',
            'phone',
        ));
        return response()->json(['quote'=>$quote]);
    }
    public static function getParents($category, $arr = []){
        $arr[] = $category;
        if($category->parent){
            $arr = self::getParents($category->parent, ($arr));
        }
        return $arr;
    }
}

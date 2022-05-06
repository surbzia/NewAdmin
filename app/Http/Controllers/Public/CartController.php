<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Cart, Product};
class CartController extends Controller
{
    public function index(Request $request){
        $cart = Cart::create([
            'user_id'=>($request->user()?$request->user()->id:0),
            'coupon_id'=>0,
            'total'=>0,
        ]);
        return response()->json(['cart'=>$cart]);
    }
    public function get(Cart $cart){
        return response()->json(['cart'=>$cart]);
    }
    public function item(Request $request, Cart $cart){
        $product = Product::findOrfail($request->product_id);
        $cart->items()->where('product_id',$request->product_id)
        ->where('variation_id',(isset($request->variation_id)?$request->variation_id:0))->delete();
        $cart->items()->create([
            'product_id'=>$request->product_id,
            'variation_id'=>(isset($request->variation_id)?$request->variation_id:0),
            'quantity'=>$request->quantity,
            'rowtotal'=>($product->price*$request->quantity)
        ]);
        $cart->update(['total'=>$cart->items->sum('rowtotal')]);
        $cart->refresh();
        return response()->json(['cart'=>$cart]);
    }
}

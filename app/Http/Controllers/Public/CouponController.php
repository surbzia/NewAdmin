<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Coupon};
class CouponController extends Controller
{
    public function view(Request $request){
        $coupon = Coupon::where('code',$request->code)->firstOrfail();
        return $coupon;
    }
}

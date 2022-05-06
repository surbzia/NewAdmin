<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponRequest;
use App\Http\Resources\CouponResource;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Repositories\ListRepository;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $listRep;
    public function __construct(ListRepository $listRep)
    {
        $this->listRep = $listRep;
        $this->listRep->bindModel(Coupon::class);
    }
    public function index()
    {
        Gate::authorize('viewAny',Coupon::class);
        $query = $this->listRep->listFilteredQuery(['code', 'discount'])
        ->select('coupons.*');
        if(isset($_GET['perpage'])&&intval($_GET['perpage'])>0){
            $query=$query->paginate($_GET['perpage']);
        }else{
            $query=$query->get();
        }
        return CouponResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CouponRequest $request)
    {
        Gate::authorize('create',Coupon::class);
        $coupon = Coupon::create($request->only('name','code','discount_type','discount','minimum_cart_value','maximum_cart_value'));
        return new CouponResource($coupon);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        Gate::authorize('view',$coupon);
        return new CouponResource($coupon);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(CouponRequest $request, Coupon $coupon)
    {
        Gate::authorize('update',$coupon);
        $coupon->update($request->only('name','code','discount_type','discount','minimum_cart_value','maximum_cart_value'));
        return new CouponResource($coupon);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        Gate::authorize('delete',$coupon);
        $coupon->delete();
        return response()->json(null, 204);
    }
}

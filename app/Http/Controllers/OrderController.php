<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\{Order, Product};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Repositories\ListRepository;

class OrderController extends Controller
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
        $this->listRep->bindModel(Order::class);
    }
    public function index()
    {
        Gate::authorize('viewAny', Order::class);
        $query = $this->listRep->listFilteredQuery(['shipping_email', 'shipping_company', 'shipping_state', 'shipping_country', 'shipping_phone', 'shipping_city', 'shipping_zip', 'shipping_address', 'shipping_first_name', 'shipping_last_name'])
            ->select('orders.*');

        if (isset($_GET['status'])) {
            $query = $query->where('order_status', $_GET['status']);
        }

        if (isset($_GET['perpage']) && intval($_GET['perpage']) > 0) {
            $query = $query->paginate($_GET['perpage']);
        } else {
            $query = $query->get();
        }
        return OrderResource::collection($query);
    }
    public function store(OrderRequest $request)
    {
        Gate::authorize('create', Order::class);
        $arr = $request->only(
            'shipping_email',
            'shipping_notes',
            'shipping_first_name',
            'shipping_last_name',
            'shipping_address',
            'shipping_city',
            'shipping_country',
            'shipping_company',
            'shipping_state',
            'shipping_zip',
            'shipping_phone',
            'billing_first_name',
            'billing_last_name',
            'billing_company',
            'billing_email',
            'billing_phone',
            'billing_country',
            'billing_state',
            'billing_city',
            'billing_zipcode',
            'billing_address',
        );
        $order = Order::create($arr);
        $total = 0;
        foreach ($request->items as $key => $value) {
            $product = Product::find($value['id']);
            $order->products()->create([
                'product_id' => $product->id,
                'quantity' => $value['quantity'],
                'rowtotal' => ($product->actual_price * $value['quantity'])
            ]);
            $total += ($product->actual_price * $value['quantity']);
        }
        $order->subtotal = $total;
        $total_before_discount = ($total);
        $total_with_discount = ($total_before_discount - $request->discount_amount);
        $tax_amount = (($total_with_discount / 100) * $request->tax_percent);
        $order->discount_amount = $request->discount_amount;
        $order->tax_percent = $request->tax_percent;
        $order->tax_amount = $tax_amount;
        $order->total = ($total_with_discount + $tax_amount);
        $order->save();
        return new OrderResource($order);
    }
    public function update(OrderRequest $request, Order $order)
    {
        Gate::authorize('update', $order);
        $arr = $request->only(
            'shipping_email',
            'shipping_notes',
            'shipping_first_name',
            'shipping_last_name',
            'shipping_address',
            'shipping_city',
            'shipping_country',
            'shipping_company',
            'shipping_state',
            'shipping_zip',
            'shipping_phone',
            'billing_first_name',
            'billing_last_name',
            'billing_company',
            'billing_email',
            'billing_phone',
            'billing_country',
            'billing_state',
            'billing_city',
            'billing_zipcode',
            'billing_address',
        );
        $order->update($arr);
        $total = 0;
        $order->products()->delete();
        foreach ($request->items as $key => $value) {
            $product = Product::find($value['id']);
            $order->products()->create([
                'product_id' => $product->id,
                'quantity' => $value['quantity'],
                'rowtotal' => ($product->price * $value['quantity'])
            ]);
            $total += ($product->price * $value['quantity']);
        }
        $order->total = $total;
        $order->save();
        return new OrderResource($order);
    }
    public function show(Order $order)
    {
        Gate::authorize('view', $order);
        $order->load('products', 'products.product');
        return new OrderResource($order);
    }
    public function destroy(Order $order)
    {
        Gate::authorize('delete', $order);
        $order->products()->delete();
        $order->delete();
        return response()->json(null, 204);
    }
}

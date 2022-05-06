<?php

namespace App\Http\Controllers;

// use App\Http\Requests\ProductQuoteRequest;
use App\Http\Resources\ProductQuoteResource;
use App\Models\ProductQuote;
use Illuminate\Support\Facades\Gate;
use App\Repositories\ListRepository;
use Illuminate\Http\Request;
class ProductQuoteController extends Controller
{
    protected $listRep;
    public function __construct(ListRepository $listRep)
    {
        $this->listRep = $listRep;
        $this->listRep->bindModel(ProductQuote::class);
    }
    public function index()
    {
        Gate::authorize('viewAny',ProductQuote::class);
        $query = $this->listRep->listFilteredQuery(['email', 'message'])
        ->select('product_quotes.*');
        if(isset($_GET['perpage'])&&intval($_GET['perpage'])>0){
            $query=$query->paginate($_GET['perpage']);
        }else{
            $query=$query->get();
        }
        return ProductQuoteResource::collection($query);
    }
    public function update(Request $request, ProductQuote $productQuote)
    {
        $productQuote->update($request->only('is_new'));
        return new ProductQuoteResource($productQuote);
    }
    public function show(ProductQuote $productQuote)
    {
        Gate::authorize('view',$productQuote);
        $productQuote->load('product');
        return new ProductQuoteResource($productQuote);
    }
    public function destroy(ProductQuote $productQuote)
    {
        Gate::authorize('delete',$productQuote);
        $productQuote->delete();
        return response()->json(null, 204);
    }
}

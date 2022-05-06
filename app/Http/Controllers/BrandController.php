<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\{Brand, User};
use Illuminate\Support\Facades\Gate;
use App\Repositories\ListRepository;
use App\Repositories\FileRepository;
use DB;
use Illuminate\Http\Request;
use App\Imports\BrandsImport;
use App\Jobs\ExportBrands as ExportBrandsJob;
use Excel;
class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $listRep;
    protected $file;
    public function __construct(ListRepository $listRep, FileRepository $file)
    {
        $this->listRep = $listRep;
        $this->listRep->bindModel(Brand::class);
        $this->file = $file;
    }
    public function index()
    {
        Gate::authorize('viewAny',Brand::class);
        $query = $this->listRep->listFilteredQuery(['name', 'slug'])
        ->select('brands.*');
        if(isset($_GET['perpage'])&&intval($_GET['perpage'])>0){
            $query=$query->paginate($_GET['perpage']);
        }else{
            $query=$query->get();
        }
        return BrandResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        Gate::authorize('create',Brand::class);
        $brand = Brand::create($request->only('name','slug'));
        if($request->image){
            $this->file->create([$request->image], 'brands', $brand->id, 1);
        }
        return new BrandResource($brand);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        Gate::authorize('view',$brand);
        return new BrandResource($brand);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, Brand $brand)
    {
        Gate::authorize('update',$brand);
        $brand->update($request->only('name','slug'));
        if($request->image){
            $this->file->create([$request->image], 'brands', $brand->id, 1);
        }
        return new BrandResource($brand);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        Gate::authorize('delete',$brand);
        $brand->delete();
        return response()->json(null, 204);
    }

    public function import(Request $request){
        $path = $request->file->store('brands_import');
        Excel::queueImport(new BrandsImport, storage_path(('app/public/'.$path)));
    }
    public function export(Request $request){
        ExportBrandsJob::dispatch(User::find($request->user()->id))->onQueue('high');
    }
}

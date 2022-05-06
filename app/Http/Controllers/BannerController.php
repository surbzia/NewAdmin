<?php

namespace App\Http\Controllers;

use App\Http\Requests\BannerRequest;
use App\Http\Resources\BannerResource;
use App\Models\Banner;
use Illuminate\Support\Facades\Gate;
use App\Repositories\ListRepository;
use App\Repositories\FileRepository;
class BannerController extends Controller
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
        $this->listRep->bindModel(Banner::class);
        $this->file = $file;
    }
    public function index()
    {
        Gate::authorize('viewAny',Banner::class);
        $query = $this->listRep->listFilteredQuery(['redirect_to', 'page'])
        ->select('banners.*');
        if(isset($_GET['perpage'])&&intval($_GET['perpage'])>0){
            $query=$query->paginate($_GET['perpage']);
        }else{
            $query=$query->get();
        }
        return BannerResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BannerRequest $request)
    {
        Gate::authorize('create',Banner::class);
        $banner = Banner::create($request->only('redirect_to','page'));
        if($request->image){
            $this->file->create([$request->image], 'banners', $banner->id, 1);
        }
        return new BannerResource($banner);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        Gate::authorize('view',$banner);
        return new BannerResource($banner);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(BannerRequest $request, Banner $banner)
    {
        Gate::authorize('update',$banner);
        $banner->update($request->only('redirect_to','page'));
        if($request->image){
            $this->file->create([$request->image], 'banners', $banner->id, 1);
        }
        return new BannerResource($banner);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        Gate::authorize('delete',$banner);
        $banner->delete();
        return response()->json(null, 204);
    }
}

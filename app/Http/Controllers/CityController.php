<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityRequest;
use App\Http\Resources\CityResource;
use App\Models\City;
use App\Repositories\ListRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
class CityController extends Controller
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
        $this->listRep->bindModel(City::class);
    }

    public function index()
    {
        Gate::authorize('viewAny',City::class);
        $query = $this->listRep->listFilteredQuery(['cities.name', 'states.name'])
        ->leftJoin('states','states.id','=','cities.state_id')
        ->select('cities.*','states.name as state_name');
        if(isset($_GET['state_id'])){
            $query = $query->where('state_id',intval($_GET['state_id']));
        }
        if(isset($_GET['perpage'])&&intval($_GET['perpage'])>0){
            $query=$query->paginate($_GET['perpage']);
        }else{
            $query=$query->get();
        }
        return CityResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CityRequest $request)
    {
        Gate::authorize('create',City::class);
        $city = City::create($request->only('name','state_id'));
        return new CityResource($city);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        Gate::authorize('view',$city);
        return new CityResource($city);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(CityRequest $request, City $city)
    {
        Gate::authorize('update',$city);
        $city->update($request->only('name','state_id'));
        return new CityResource($city);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        Gate::authorize('delete',$city);
        $city->delete();
        return response()->json(null, 204);
    }
}

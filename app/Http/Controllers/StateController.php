<?php

namespace App\Http\Controllers;

use App\Http\Requests\StateRequest;
use App\Http\Resources\StateResource;
use App\Models\State;
use App\Repositories\ListRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
class StateController extends Controller
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
        $this->listRep->bindModel(State::class);
    }

    public function index()
    {
        Gate::authorize('viewAny',State::class);
        $query = $this->listRep->listFilteredQuery(['states.name','country_id','tax_percent','countries.name','countries.iso_code'])
        ->leftJoin('countries','countries.id','=','states.country_id')
        ->select('states.*','countries.name as country_name');
        if(isset($_GET['country_id'])){
            $query = $query->where('country_id',intval($_GET['country_id']));
        }
        if(isset($_GET['perpage'])&&intval($_GET['perpage'])>0){
            $query=$query->paginate($_GET['perpage']);
        }else{
            $query=$query->get();
        }
        return StateResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StateRequest $request)
    {
        Gate::authorize('create',State::class);
        $state = State::create($request->only('name','country_id','tax_percent'));
        return new StateResource($state);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function show(State $state)
    {
        Gate::authorize('view',$state);
        return new StateResource($state);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(StateRequest $request, State $state)
    {
        Gate::authorize('update',$state);
        $state->update($request->only('name','country_id','tax_percent'));
        return new StateResource($state);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $state)
    {
        Gate::authorize('delete',$state);
        $state->delete();
        return response()->json(null, 204);
    }
}

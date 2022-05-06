<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserExemptionRequest;
use App\Http\Resources\UserExemptionResource;
use App\Models\UserExemption;
use App\Repositories\ListRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Repositories\FileRepository;
use DB;
class UserExemptionController extends Controller
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
        $this->file = $file;
        $this->listRep->bindModel(UserExemption::class);
    }

    public function index()
    {
        Gate::authorize('viewAny',UserExemption::class);
        $query = $this->listRep->listFilteredQuery(['state_id', 'user_id', 'states.name', 'users.name', 'users.email'])
        ->leftJoin('users','users.id','=','user_exemptions.user_id')
        ->leftJoin('states','states.id','=','user_exemptions.state_id')
        ->select('user_exemptions.*', DB::raw('states.name as state_name'));
        if(isset($_GET['user_id'])){
            $query=$query->where('user_id',$_GET['user_id']);
        }
        if(isset($_GET['user_email'])){
            $query=$query->where('users.email',$_GET['user_email']);
        }
        if(isset($_GET['state_id'])){
            $query=$query->where('state_id',$_GET['state_id']);
        }
        if(isset($_GET['perpage'])&&intval($_GET['perpage'])>0){
            $query=$query->paginate($_GET['perpage']);
        }else{
            $query=$query->get();
        }
        return UserExemptionResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserExemptionRequest $request)
    {
        Gate::authorize('create',UserExemption::class);
        $userExemption = UserExemption::create($request->only('state_id','user_id'));
        if($request->image){
            $this->file->create([$request->image], 'user_exemptions', $userExemption->id, 1);
        }
        return new UserExemptionResource($userExemption);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserExemption  $userExemption
     * @return \Illuminate\Http\Response
     */
    public function show(UserExemption $userExemption)
    {
        Gate::authorize('view',$userExemption);
        return new UserExemptionResource($userExemption);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserExemption  $userExemption
     * @return \Illuminate\Http\Response
     */
    public function update(UserExemptionRequest $request, UserExemption $userExemption)
    {
        Gate::authorize('update',$userExemption);
        $userExemption->update($request->only('state_id','user_id'));
        if($request->image){
            $this->file->create([$request->image], 'user_exemptions', $userExemption->id, 1);
        }
        return new UserExemptionResource($userExemption);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserExemption  $userExemption
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserExemption $userExemption)
    {
        Gate::authorize('delete',$userExemption);
        $userExemption->delete();
        return response()->json(null, 204);
    }
}

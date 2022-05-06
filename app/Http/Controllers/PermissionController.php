<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Requests\PermissionRequest;
use App\Http\Resources\PermissionResource;
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('viewAny',Permission::class);
        if(isset($_GET['sortCol'])){
            $permissions = Permission::orderBy($_GET['sortCol'],($_GET['sortByDesc']==1?'desc':'asc'));
        }else{
            $permissions = Permission::orderBy('permissions.id','desc');
        }
        if(!empty($_GET['search'])){
            $permissions = $permissions->Where(
                function($query) {
                $q = $_GET['search'];
                $query->orWhere('permissions.title', 'like', '%'.$q.'%')
                ->orWhere('permissions.name', 'like', '%'.$q.'%');
            });
        }
        if(isset($_GET['perpage'])&&intval($_GET['perpage'])>0){
            $permissions=$permissions->paginate($_GET['perpage']);
        }else{
            $permissions=$permissions->get();
        }
        return PermissionResource::collection($permissions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        Gate::authorize('create',Permission::class);
        $permission = Permission::create($request->only('name','title'));
        $permission->save();
        return new PermissionResource($permission);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        Gate::authorize('view',$permission);
        return new PermissionResource($permission);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, Permission $permission)
    {
        Gate::authorize('update',$permission);
        $permission->update($request->only('name','title'));
        return new PermissionResource($permission);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        Gate::authorize('delete',$permission);
        $permission->delete();
        return response()->json(null, 204);
    }
}

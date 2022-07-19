<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
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
        if(isset($_GET['sortCol'])){
            $permissions = Permission::orderBy($_GET['sortCol'],($_GET['sortByDesc']==1?'desc':'asc'));
        }else{
            $permissions = Permission::orderBy('permissions.id','desc');
        }
        if(!empty($_GET['search'])){
            $permissions = $permissions->Where(
                function($query) {
                $q = $_GET['search'];
                    $query->orWhere('permissions.module', 'like', '%' . $q . '%')
                ->orWhere('permissions.name', 'like', '%'.$q.'%');
            });
        }

        if(isset($_GET['perpage'])&&intval($_GET['perpage'])>0){
            $permissions=$permissions->paginate($_GET['perpage']);
        }else{
            $permissions=$permissions->get();
        }

        if (isset($_GET['byModule']) && $_GET['byModule']) {

            $permissions = Permission::all()->groupBy('module');
        }
        return PermissionResource::collection($permissions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $permission = Permission::create($request->only('name', 'module', 'slug'));
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

        return new PermissionResource($permission);
    }

    public function GetAllModules()
    {
        $permissions = Permission::distinct()->get('module');
        return new PermissionResource($permissions);
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
        $permission->update($request->only('name', 'module', 'slug'));
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
        $permission->delete();
        return response()->json(null, 204);
    }
}

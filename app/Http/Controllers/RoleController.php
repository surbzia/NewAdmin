<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RoleRequest;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny',Role::class);
        if(isset($_GET['sortCol'])){
            $roles = Role::orderBy($_GET['sortCol'],($_GET['sortByDesc']==1?'desc':'asc'));
        }else{
            $roles = Role::orderBy('roles.id','desc');
        }
        if(!empty($_GET['search'])){
            $roles = $roles->Where(
                function($query) {
                $q = $_GET['search'];
                $query->orWhere('roles.title', 'like', '%'.$q.'%')
                ->orWhere('roles.name', 'like', '%'.$q.'%');
            });
        }
        if(isset($_GET['perpage'])&&intval($_GET['perpage'])>0){
            $roles=$roles->paginate($_GET['perpage']);
        }else{
            $roles=$roles->get();
        }
        return RoleResource::collection($roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        Gate::authorize('create',Role::class);
        $role = Role::create($request->only('name','title'));
        $role->save();
        if(isset($request->permissions)){
            $permissions = $request->permissions;
            foreach($permissions as $permission){
                $role->permissions()->create([
                    'permission_id'=>$permission,
                ]);
            }
        }
        return new RoleResource($role);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        Gate::authorize('view',$role);
        $role->load('permissions','permissions.permission');
        return new RoleResource($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\RoleRequest  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role)
    {
        Gate::authorize('update',$role);
        $role->update($request->only('name','title'));
        $role->permissions()->delete();
        $permissions = $request->permissions;
        foreach($permissions as $permission){
            $role->permissions()->create([
                'permission_id'=>$permission,
            ]);
        }
        return new RoleResource($role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        Gate::authorize('delete',$role);
        $role->permissions()->delete();
        $role->delete();
        return response()->json(null, 204);
    }
}
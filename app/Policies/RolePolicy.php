<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return optional($user->permissions()->where('permission_id',56)->first())->id>0;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Role  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Role $model)
    {
        return optional($user->permissions()->where('permission_id',60)->first())->id>0;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return optional($user->permissions()->where('permission_id',57)->first())->id>0;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Role  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Role $model)
    {
        return optional($user->permissions()->where('permission_id',58)->first())->id>0;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Role  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Role $model)
    {
        return optional($user->permissions()->where('permission_id',59)->first())->id>0;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Role  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Role $model)
    {
        return optional($user->permissions()->where('permission_id',59)->first())->id>0;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Role  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Role $model)
    {
        return optional($user->permissions()->where('permission_id',59)->first())->id>0;
    }
}

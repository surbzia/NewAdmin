<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
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
        return optional($user->permissions()->where('permission_id',159)->first())->id>0;
    }
    public function view(User $user, Order $order)
    {
        return optional($user->permissions()->where('permission_id',160)->first())->id>0;
    }
    public function create(User $user)
    {
        return optional($user->permissions()->where('permission_id',178)->first())->id>0;
    }
    public function statusHandle(User $user, Order $order)
    {
        return optional($user->permissions()->where('permission_id',161)->first())->id>0;
    }
    public function paymentCharge(User $user, Order $order)
    {
        return optional($user->permissions()->where('permission_id',162)->first())->id>0;
    }
}

<?php

namespace App\Policies;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CouponPolicy
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
        return optional($user->permissions()->where('permission_id',113)->first())->id>0;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Coupon $coupon)
    {
        return optional($user->permissions()->where('permission_id',117)->first())->id>0;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return optional($user->permissions()->where('permission_id',114)->first())->id>0;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Coupon $coupon)
    {
        return optional($user->permissions()->where('permission_id',115)->first())->id>0;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Coupon $coupon)
    {
        return optional($user->permissions()->where('permission_id',116)->first())->id>0;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Coupon $coupon)
    {
        return optional($user->permissions()->where('permission_id',116)->first())->id>0;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Coupon $coupon)
    {
        return optional($user->permissions()->where('permission_id',116)->first())->id>0;
    }
}

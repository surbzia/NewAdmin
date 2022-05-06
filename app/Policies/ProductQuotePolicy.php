<?php

namespace App\Policies;

use App\Models\ProductQuote;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductQuotePolicy
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
        return optional($user->permissions()->where('permission_id',143)->first())->id>0;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProductQuote  $productQuote
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ProductQuote $productQuote)
    {
        return optional($user->permissions()->where('permission_id',144)->first())->id>0;
    }
    
    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProductQuote  $productQuote
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ProductQuote $productQuote)
    {
        return optional($user->permissions()->where('permission_id',147)->first())->id>0;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProductQuote  $productQuote
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ProductQuote $productQuote)
    {
        return optional($user->permissions()->where('permission_id',147)->first())->id>0;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProductQuote  $productQuote
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ProductQuote $productQuote)
    {
        return optional($user->permissions()->where('permission_id',147)->first())->id>0;
    }
}

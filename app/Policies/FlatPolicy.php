<?php

namespace App\Policies;

use App\Models\Flat;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FlatPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Flat $flat): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //return $user->hasRole('admin');
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Flat $flat): bool
    {
        return true;
        //return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Flat $flat): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Flat $flat): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Flat $flat): bool
    {
        return false;
    }
    public function viewBookedFlats(User $user)
    {
        // فقط الأدمن يمكنه عرض الشقق المحجوزة
        return $user->hasRole('admin');
    }
}

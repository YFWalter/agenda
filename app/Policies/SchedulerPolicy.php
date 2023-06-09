<?php

namespace App\Policies;

use App\Models\Scheduler;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SchedulerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Scheduler $scheduler): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Scheduler $scheduler)
    {
        // Si queremos hacer que el super-admin reagende una cita cambiamos la condicion > 24, return true.
        if($scheduler->from->diffInHours() < 24){
            return false;
        }
        
        if(($scheduler->client_user_id == $user->id) OR ($scheduler->staff_user_id == $user->id)){
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Scheduler $scheduler)
    {
        if($scheduler->to->isPast()){
            return false;
        }
        
        if ($scheduler->from->diffInHours() < 24) {
            return false;
        }

        if(($scheduler->client_user_id == $user->id) OR ($scheduler->staff_user_id == $user->id)){
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Scheduler $scheduler): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Scheduler $scheduler): bool
    {
        //
    }
}

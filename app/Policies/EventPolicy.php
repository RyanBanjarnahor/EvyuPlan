<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EventPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Event $event): bool
    {
         // Allow admin to delete any event
         if ($user->hasRole('admin')) {
            return true;
        }

        // Allow the owner of the event to delete
        return $user->id === $event->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
          // Allow admin to delete any event
          if ($user->hasRole('admin')) {
            return true;
        }

        // Allow the owner of the event to delete
        return $user->id === $event->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Event $event): bool
    {
          // Allow admin to delete any event
          if ($user->hasRole('admin')) {
            return true;
        }

        // Allow the owner of the event to delete
        return $user->id === $event->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Event $event): bool
    {
          // Allow admin to delete any event
          if ($user->hasRole('admin')) {
            return true;
        }

        // Allow the owner of the event to delete
        return $user->id === $event->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Event $event): bool
    {
          // Allow admin to delete any event
          if ($user->hasRole('admin')) {
            return true;
        }

        // Allow the owner of the event to delete
        return $user->id === $event->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Event $event): bool
    {
          // Allow admin to delete any event
          if ($user->hasRole('admin')) {
            return true;
        }

        // Allow the owner of the event to delete
        return $user->id === $event->user_id;
    }
}

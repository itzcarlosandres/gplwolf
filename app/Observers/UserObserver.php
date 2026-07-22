<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        //
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // Check if points were changed
        if ($user->isDirty('points')) {
            $this->updateUserRank($user);
        }
    }

    /**
     * Update user's rank based on their current points.
     */
    protected function updateUserRank(User $user): void
    {
        // Get all ranks ordered by points ascending
        $ranks = \App\Models\Rank::orderBy('min_points', 'asc')->get();
        
        // Find the highest rank the user qualifies for based on CURRENT points
        $newCurrentRank = $ranks->where('min_points', '<=', $user->points)
                                ->sortByDesc('min_points')
                                ->first();
        
        $oldCurrentRank = $user->rank;
        $oldMaxRank = $user->maxRank;
        
        // Update CURRENT rank (dynamic - can go up or down)
        $currentRankChanged = false;
        if (!$user->current_rank_id || ($newCurrentRank && $newCurrentRank->id !== $user->current_rank_id) || (!$newCurrentRank && $user->current_rank_id)) {
            $user->current_rank_id = $newCurrentRank ? $newCurrentRank->id : null;
            $currentRankChanged = true;
        }
        
        // Update MAX rank (permanent - only goes up, never down)
        $maxRankChanged = false;
        if ($newCurrentRank) {
            if (!$user->max_rank_id || $newCurrentRank->min_points > ($oldMaxRank->min_points ?? 0)) {
                $user->max_rank_id = $newCurrentRank->id;
                $maxRankChanged = true;
            }
        }
        
        // Save changes if any rank was updated
        if ($currentRankChanged || $maxRankChanged) {
            $user->saveQuietly(); // Prevents infinite loop
        }
        
        // Create notification AND send email if user reached a NEW MAX rank (achievement)
        if ($maxRankChanged && $newCurrentRank) {
            // Send email
            \Illuminate\Support\Facades\Mail::to($user->email)
                ->queue(new \App\Mail\RankUpgradeNotification($user, $newCurrentRank, $oldMaxRank));
            
            // Create in-app notification
            \App\Models\Notification::create([
                'user_id' => $user->id,
                'type' => 'rank_upgrade',
                'title' => '¡Nuevo Rango Desbloqueado!',
                'message' => "¡Felicidades! Has alcanzado el rango {$newCurrentRank->name} y desbloqueas {$newCurrentRank->discount_percentage}% de descuento permanente.",
                'is_read' => false,
            ]);
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}

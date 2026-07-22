<?php

namespace App\Services;

use App\Models\User;
use App\Models\DailyLogin;
use App\Models\Setting;
use Carbon\Carbon;

class GamificationService
{
    /**
     * Get the current daily login status for a user.
     */
    public function getDailyStatus(User $user)
    {
        $daily = $user->dailyLogin()->firstOrCreate([
            'user_id' => $user->id
        ], [
            'logged_at' => Carbon::yesterday(), // Default to yesterday so they can claim today
            'current_streak' => 0,
            'max_streak' => 0
        ]);

        $lastLoginDate = $daily->logged_at;
        $today = Carbon::today();
        $isClaimedToday = $lastLoginDate->isSameDay($today);
        
        // Calculate Streak Display
        // If last login was yesterday, streak is maintained.
        // If last login was today, streak is maintained.
        // If last login was before yesterday, streak is broken, but we don't reset DB until next claim to show "Missed" state in UI if we want.
        // Actually, for UI matrix, we want to know effective streak.
        
        $effectiveStreak = $daily->current_streak;
        if ($lastLoginDate->lt(Carbon::yesterday())) {
             // Streak is effectively 0 for next claim, but maybe we want to show 0 in UI
             $effectiveStreak = 0;
        }

        // Get Rewards Config
        $config = json_decode(Setting::where('key', 'gamification_rewards')->value('value') ?? '{}', true);
        $rewards = $config['rewards'] ?? [];
        
        // Determine next day index (1-7)
        // If claimed today, we are at current_streak. Next is current_streak + 1.
        // If not claimed today (and not broken), we are pending current_streak + 1.
        // If broken, we are starting Day 1.
        
        $currentDayIndex = $effectiveStreak % 7; 
        if ($currentDayIndex == 0 && $effectiveStreak > 0) $currentDayIndex = 7; // Completed a cycle?? No modulo 7 means 0 for 7, 14. 
        // Let's simpler logic: Streak 0 -> Next Day 1. Streak 1 -> Next Day 2. Streak 6 -> Next Day 7. Streak 7 -> Next Day 1.
        
        // Correct logic:
        // Streak | Next Claim Day
        // 0      | 1
        // 1      | 2
        // ...
        // 6      | 7
        // 7      | 1 (Reset cycle)
        
        $nextDay = ($effectiveStreak % 7) + 1;
        
        $nextPoints = $rewards[$nextDay] ?? 10;

        return [
            'streak' => $effectiveStreak,
            'claimed_today' => $isClaimedToday,
            'next_day' => $nextDay,
            'next_points' => $nextPoints,
            'week_calendar' => $this->buildWeekCalendar($effectiveStreak, $isClaimedToday, $rewards),
            'last_claim_at' => $lastLoginDate, // Needed for countdown timer
        ];
    }

    /**
     * Attempt to claim the daily reward.
     */
    public function claimDailyReward(User $user)
    {
        $daily = $user->dailyLogin()->firstOrCreate([
            'user_id' => $user->id
        ], ['logged_at' => Carbon::yesterday()]);

        $today = Carbon::today();
        
        if ($daily->logged_at->isSameDay($today)) {
            return ['success' => false, 'message' => 'Ya has reclamado tu recompensa de hoy.'];
        }

        // Check streak continuity
        if ($daily->logged_at->lt(Carbon::yesterday())) {
            // Broken streak
            $daily->current_streak = 0;
        }

        // Calculate Reward
        $nextDay = ($daily->current_streak % 7) + 1;
        
        $config = json_decode(Setting::where('key', 'gamification_rewards')->value('value') ?? '{}', true);
        $rewards = $config['rewards'] ?? [];
        $points = $rewards[$nextDay] ?? 10;

        // Update User Points
        $user->addPoints($points, 'daily_login', "Recompensa Día $nextDay");

        // Update Daily Login Record
        $daily->logged_at = $today;
        $daily->current_streak++;
        if ($daily->current_streak > $daily->max_streak) {
            $daily->max_streak = $daily->current_streak;
        }
        $daily->save();

        return [
            'success' => true, 
            'points' => $points, 
            'day' => $nextDay,
            'new_streak' => $daily->current_streak
        ];
    }

    private function buildWeekCalendar($streak, $isClaimedToday, $rewards)
    {
        // We want to visualise 7 days.
        // Scenario A: Streak 3. Claimed today.
        // Days 1, 2, 3 are Checked. Day 4 is Locked.
        
        // Scenario B: Streak 2. Not claimed today.
        // Days 1, 2 are Checked. Day 3 is Active (Today). Day 4 Locked.
        
        // Scenario C: Streak Broken (0). Not claimed today.
        // Day 1 Active. others Locked.
        
        $calendar = [];
        $cycleStreak = $streak % 7; // 0..6
        if ($cycleStreak == 0 && $streak > 0 && $isClaimedToday) $cycleStreak = 7; // Just finished day 7

        // However, if we are mid-cycle, say streak 2 (Day 1, 2 done).
        // If claimed today, cycleStreak=2. Days 1,2 check.
        // If not claimed, pending day is 3. effectiveStreak=2.
        
        // Let's iterate 1 to 7
        for ($i = 1; $i <= 7; $i++) {
            $status = 'locked';
            
            if ($isClaimedToday) {
                if ($i <= $cycleStreak) $status = 'claimed';
                else $status = 'locked';
            } else {
                if ($i <= $cycleStreak) $status = 'claimed';
                elseif ($i == $cycleStreak + 1) $status = 'active';
                else $status = 'locked';
            }

            // Correction for reset cycle (Streak 7 completed -> next is Day 1)
            // If streak=7 and claimed today -> Show full completed week? Or reset empty?
            // Usually show completed until tomorrow.
            
            $calendar[] = [
                'day' => $i,
                'points' => $rewards[$i] ?? 0,
                'status' => $status
            ];
        }
        
        return $calendar;
    }
}

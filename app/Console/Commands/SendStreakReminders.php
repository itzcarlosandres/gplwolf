<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DailyLogin;
use App\Models\Notification;
use App\Mail\StreakReminderMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendStreakReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'points:send-streak-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily streak reminders to users who have not claimed their login points today';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting streak reminders check...');

        $yesterday = Carbon::yesterday();

        // Find daily logins where streak is active, and last login claim was yesterday.
        // This means they have not claimed today yet.
        $dailyLogins = DailyLogin::where('current_streak', '>', 0)
            ->whereDate('logged_at', $yesterday)
            ->with('user')
            ->get();

        $count = 0;

        foreach ($dailyLogins as $daily) {
            $user = $daily->user;
            if (!$user) continue;

            $this->info("Sending streak reminder to: {$user->name} ({$user->email}) | Streak: {$daily->current_streak}");

            try {
                // 1. Send Email Notification
                Mail::to($user->email)->queue(new StreakReminderMail($user, $daily->current_streak));

                // 2. Create In-App Notification
                Notification::create([
                    'user_id' => $user->id,
                    'type' => 'streak_reminder',
                    'title' => '🔥 ¡No pierdas tu racha!',
                    'message' => "Tienes una racha activa de {$daily->current_streak} días. Reclama tus puntos de hoy para no perder el Cofre Legendario.",
                    'icon' => 'fa-fire',
                    'link' => route('user.rewards'),
                    'is_read' => false,
                ]);

                $count++;
            } catch (\Exception $e) {
                Log::error("Error sending streak reminder to {$user->email}: " . $e->getMessage());
                $this->error("Failed for {$user->email}");
            }
        }

        $this->info("Streak reminders sent successfully: {$count} users notified.");
    }
}

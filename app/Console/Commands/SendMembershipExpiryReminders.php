<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\MembershipExpiring;
use Illuminate\Console\Command;
use Carbon\Carbon;

class SendMembershipExpiryReminders extends Command
{
    protected $signature = 'membership:send-expiry-reminders';
    protected $description = 'Send email reminders for memberships expiring within 30 days';

    public function handle()
    {
        $members = User::members()
            ->where('membership_status', 'active')
            ->whereNotNull('expiry_date')
            ->whereBetween('expiry_date', [
                Carbon::today(),
                Carbon::today()->addDays(30)
            ])
            ->get();

        foreach ($members as $member) {
            $daysLeft = Carbon::today()->diffInDays($member->expiry_date);
            $member->notify(new MembershipExpiring($daysLeft));
            $this->info("Reminder sent to: {$member->email}");
        }

        $this->info("Total reminders sent: " . $members->count());
    }
}
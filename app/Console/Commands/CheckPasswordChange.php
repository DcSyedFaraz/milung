<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;
use Log;

class CheckPasswordChange extends Command
{
    protected $signature = 'check:passwordchange';
    protected $description = 'Check if users have changed their password in the last month and update OTP column if not';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            $passwordUpdatedAt = Carbon::parse($user->password_updated_at);
            $oneMonthAgo = Carbon::now()->subMonth();

            if ($passwordUpdatedAt->lessThanOrEqualTo($oneMonthAgo)) {
                $user->otp = $user->password; // Save the current password without hashing
                $user->save();
                Log::info("Updated OTP for user ID {$user->id}.");
            }
        }

        $this->info('Checked and updated OTP for users whose password has not been changed in the last month.');
    }
}

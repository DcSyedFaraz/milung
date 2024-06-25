<?php

namespace App\Jobs;

use App\Mail\AccountCreated;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class ProcessUserNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $user;
    protected $otp;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $otp)
    {
        $this->user = $user;
        $this->otp = $otp;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $admin = User::role(['Admin', 'Internal'])->get();

        Mail::to($this->user->email)->send(new AccountCreated($this->user, $this->otp));

        $message = "Hello!\n\nA new buyer has been successfully added to the system.\n\nBuyer ID: {$this->user->userid}\n\nThank you!";

        Notification::send($admin, new UserNotification($message, 'New Buyer', 'editbuyer', ['id' => $this->user->id]));
    }
}

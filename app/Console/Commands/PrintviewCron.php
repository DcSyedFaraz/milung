<?php

namespace App\Console\Commands;

use App\Mail\PriceInquiryNotification;
use App\Models\Order;
use App\Notifications\UserNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class PrintviewCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'printview:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder to users to upload printview if not done within 7 days';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Get orders assigned to suppliers more than 7 days ago and without printview
        $orders = Order::where('assigned_to_supplier_at', '<=', Carbon::now()->subDays(7))
            ->whereDoesntHave('printview', function ($query) {
                $query->select(\DB::raw(1));
            })
            ->get();

        foreach ($orders as $order) {
            // Assuming you have the user's email in the order or related table
            $user = $order->supplier; // Modify this as per your actual data model

            $message = "This is a friendly reminder to upload the print view for your order #{{ $order->id }}. It's been 7 days since the order was assigned to the supplier.</p>
            <p>Please log in to your account and upload the required print view at your earliest convenience.";


            // Send the notification to the supplier
            \Notification::send($user, new UserNotification($message, 'Reminder: Please Upload Print View'));

            // Send the email to the supplier
            \Mail::to($user->email)->send(new PriceInquiryNotification($message, 'Reminder: Please Upload Print View'));

            // Optionally, log that the reminder was sent
            $this->info('Reminder sent for order ID: ' . $order->id);
        }

    }

}

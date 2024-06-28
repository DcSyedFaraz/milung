<?php

namespace App\Http\Controllers;

use App\Models\EventLog;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    protected function logEvent($event, $description)
    {
        EventLog::create([
            'event' => $event,
            'description' => $description,
            'user_id' => auth()->id(),
            'created_at' => Carbon::now('Asia/Hong_Kong'),
            'updated_at' => Carbon::now('Europe/Berlin')
        ]);
    }
}

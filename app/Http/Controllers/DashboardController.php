<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Assignment;

class DashboardController extends Controller
{
    /**
     * Return JSON summary of asset movement (assignments) within a date range.
     */
    Public function sse()
    {
        header('Content-type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');

        $eventData = [
            'totalUsers' => User::count(),
            'totalAssets' => Assets::count(),
            'totalUsers' => User::count(),
            'totalUsers' => User::count(),

        ];
        echo "data:" . json_encode($eventData) . "\n\n";
        ob_flush();
        flush();

    }
}



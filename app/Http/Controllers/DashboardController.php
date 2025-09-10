<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Assignment;
use App\Models\User;
use App\Models\Assets;

class DashboardController extends Controller
{
/**
 * Stream Server-Sent Events with dashboard metrics.
 */
public function sse()
{
    $eventData = [
        'totalUsers' => User::count(),
        'totalAssets' => Assets::count(),
        'assignedAssets' => Assignment::count(),
        'unassignedAssets' => Assets::whereDoesntHave('assignment')->count(),
        'activeUsers' => User::where('active', true)->count(),
    ];

    return response()->stream(function () use ($eventData) {
        echo "data: " . json_encode($eventData) . "\n\n";
        ob_flush();
        flush();
    }, 200, [
        'Content-Type' => 'text/event-stream',
        'Cache-Control' => 'no-cache',
    ]);
}

}



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
    public function movementSummary(Request $request)
    {
        $startDateParam = $request->query('start_date');
        $endDateParam = $request->query('end_date');

        $start = $startDateParam ? Carbon::parse($startDateParam)->startOfDay() : Carbon::now()->subDays(30)->startOfDay();
        $end = $endDateParam ? Carbon::parse($endDateParam)->endOfDay() : Carbon::now()->endOfDay();

        $assignments = Assignment::with(['user:id,name', 'asset:id,name'])
            ->whereBetween('created_at', [$start, $end])
            ->orderByDesc('created_at')
            ->limit(500)
            ->get();

        $summary = [
            'total_assignments' => $assignments->count(),
            'unique_assets' => $assignments->pluck('asset_id')->unique()->count(),
            'unique_users' => $assignments->pluck('user_id')->unique()->count(),
            'range' => [
                'start' => $start->toDateString(),
                'end' => $end->toDateString(),
            ],
        ];

        $data = $assignments->map(function ($a) {
            return [
                'id' => $a->id,
                'asset_id' => $a->asset_id,
                'asset_name' => optional($a->asset)->name,
                'user_name' => optional($a->user)->name,
                'assigned_at' => $a->created_at?->toDateTimeString(),
            ];
        });

        return response()->json([
            'summary' => $summary,
            'assignments' => $data,
        ]);
    }
}



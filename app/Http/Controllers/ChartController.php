<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function __invoke(Request $request)
    {
        $type = $request->query('type');

        return match ($type) {
            'status'   => $this->statusSummary(),
            'priority' => $this->prioritySummary(),
            'assignee' => $this->assigneeSummary(),
            default     => response()->json([
                'error' => 'Invalid chart type. Use: status, priority, assignee'
            ], 400)
        };
    }
    /**
     * 1. STATUS SUMMARY
     */
    protected function statusSummary()
    {
        $data = Todo::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return response()->json([
            'status_summary' => [
                'pending'     => $data['pending']     ?? 0,
                'open'        => $data['open']        ?? 0,
                'in_progress' => $data['in_progress'] ?? 0,
                'completed'   => $data['completed']   ?? 0,
            ]
        ]);
    }

    /**
     * 2. PRIORITY SUMMARY
     */
    protected function prioritySummary()
    {
        $data = Todo::selectRaw('priority, COUNT(*) as total')
            ->groupBy('priority')
            ->pluck('total', 'priority');

        return response()->json([
            'priority_summary' => [
                'low'    => $data['low']    ?? 0,
                'medium' => $data['medium'] ?? 0,
                'high'   => $data['high']   ?? 0,
            ]
        ]);
    }

    /**
     * 3. ASSIGNEE SUMMARY
     */
    protected function assigneeSummary()
    {
        // Ambil daftar semua assignee
        $assignees = Todo::selectRaw('assignee')
            ->groupBy('assignee')
            ->pluck('assignee');

        $result = [];

        foreach ($assignees as $user) {
            $total = Todo::where('assignee', $user)->count();

            $pending = Todo::where('assignee', $user)
                ->where('status', 'pending')
                ->count();

            $totalTimetrackedCompleted = Todo::where('assignee', $user)
                ->where('status', 'completed')
                ->sum('time_tracked');

            $result[$user] = [
                'total_todos'                        => $total,
                'total_pending_todos'                => $pending,
                'total_timetracked_completed_todos'  => $totalTimetrackedCompleted,
            ];
        }

        return response()->json([
            'assignee_summary' => $result
        ]);
    }
}

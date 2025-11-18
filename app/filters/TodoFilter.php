<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class TodoFilter
{
    public function apply(Builder $query, array $filters): Builder
    {
        // Title (partial)
        if (!empty($filters['title'])) {
            $query->where('title', 'like', '%' . $filters['title'] . '%');
        }

        // Assignee (comma list)
        if (!empty($filters['assignee'])) {
            $query->whereIn('assignee', explode(',', $filters['assignee']));
        }

        // Status (comma list)
        if (!empty($filters['status'])) {
            $query->whereIn('status', explode(',', $filters['status']));
        }

        // Priority (comma list)
        if (!empty($filters['priority'])) {
            $query->whereIn('priority', explode(',', $filters['priority']));
        }

        // Due date range
        if (!empty($filters['start'])) {
            $query->whereDate('due_date', '>=', $filters['start']);
        }

        if (!empty($filters['end'])) {
            $query->whereDate('due_date', '<=', $filters['end']);
        }

        // Time tracked range
        if (!empty($filters['min'])) {
            $query->where('time_tracked', '>=', $filters['min']);
        }

        if (!empty($filters['max'])) {
            $query->where('time_tracked', '<=', $filters['max']);
        }

        return $query;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Filters\TodoFilter;
use App\Exports\TodosExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelReportController extends Controller
{
    public function __construct(
        protected TodoFilter $filters
    ) {}

    function export(Request $request) {
        $query = Todo::query();
        $this->filters->apply($query, $request->all());
        $todos = $query->get();
        return Excel::download(new TodosExport($todos), 'todos-report.xlsx');
    }
}

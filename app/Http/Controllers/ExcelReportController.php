<?php

namespace App\Http\Controllers;

use App\Exports\TodosExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelReportController extends Controller
{
    function export() {
        return Excel::download(new TodosExport(), 'todos-report.xlsx');
    }
}

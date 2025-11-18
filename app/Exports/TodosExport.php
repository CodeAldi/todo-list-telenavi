<?php

namespace App\Exports;

use App\Models\Todo;
use Maatwebsite\Excel\Concerns\FromArray;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class TodosExport implements FromArray, WithHeadings, WithStrictNullComparison, ShouldAutoSize, WithStyles
{
    protected $todos;

    public function __construct($todos)
    {
        $this->todos = $todos;
    }

    public function title(): string
    {
        return 'Todos Report';
    }
    public function array(): array
    {
        // $todos = Todo::all();
        
        $exportData = [];
        $iteration = 1;
        $total_time_tracked = 0;

        foreach ($this->todos as $todo) {
            $exportData[] = [
                '#' => $iteration,
                'title' => $todo->title,
                'assignee' => $todo->assignee,
                'due_date' => $todo->due_date,
                'time_tracked' => $todo->time_tracked,
                'status' => $todo->status->value,
                'priority' => $todo->priority->value, 
            ];
            $total_time_tracked += $todo->time_tracked;
            $iteration++;
        }
        $baru = ['total todo ',':', count($this->todos), 'total time tracked', ':', $total_time_tracked];

        return array_merge(
            $exportData,[
                ['','','','','','',''], // separator row
                ['total todo ',':', count($this->todos)],
                ['total time tracked', ':', $total_time_tracked],
             ]
        );
        // return [$exportData,$baru];    
    }
    
    public function headings(): array
    {
        return [
            '#',
            'Title',
            'Assignee',
            'Due Date',
            'Time Tracked',
            'Status',
            'Priority',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Apply bold font to the header row
        $sheet->getStyle('1')->getFont()->setBold(true);
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A' . ($lastRow - 1))->getFont()->setBold(true);
        $sheet->getStyle('A' . ($lastRow))->getFont()->setBold(true);
        
    }

}

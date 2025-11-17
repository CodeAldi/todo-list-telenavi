<?php

namespace App\Enums;

enum StatusTodo: string
{
    case Pending = 'pending';
    case Open = 'open';
    case InProgress = 'in_progress';
    case Completed = 'completed';
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    //

    protected $fillable = ['title','assignee','due_date','time_tracked','status','priority'];

    protected function casts(): array
    {
        return [
            'due_date' => 'datetime',
            'time_tracked' => 'integer',
            'status' => \App\Enums\StatusTodo::class,
            'priority' => \App\Enums\PriorityTodo::class,
        ];
    }
}

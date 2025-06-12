<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id',
        'date',
        'check_in_time',
        'check_in_photo',
        'check_in_location',
        'check_out_time',
        'check_out_photo',
        'check_out_location',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

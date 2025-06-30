<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeLeave extends Model
{
    protected $fillable = [
        'employee_id',
        'type',
        'leave_start',
        'leave_end',
    ];

    protected $casts = [
        'leave_start' => 'date',
        'leave_end'   => 'date',
    ];

    /**
     * Get the employee that owns the leave record.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}

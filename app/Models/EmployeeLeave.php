<?php
namespace App\Models;

use App\Enums\LeaveType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeLeave extends Model
{
    protected $fillable = [
        'employee_id',
        'leavet_start',
        'leavet_end',
    ];

    protected $casts = [
        'type'        => LeaveType::class,
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

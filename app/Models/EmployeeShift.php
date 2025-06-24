<?php
namespace App\Models;

use App\Enums\ShiftStatus;
use App\Enums\ShiftType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeShift extends Model
{
    protected $fillable = [
        'employee_id',
        'type',
        'status',
        'shift_date',
    ];

    protected $casts = [
        'type'       => ShiftType::class,
        'status'     => ShiftStatus::class,
        'shift_date' => 'date',
    ];

    /**
     * Get the employee that owns the shift.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}

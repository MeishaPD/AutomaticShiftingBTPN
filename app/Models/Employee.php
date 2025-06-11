<?php
namespace App\Models;

use App\Enums\Gender;
use App\Enums\Location;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'name',
        'gender',
        'religion',
        'location',
        'is_onboarding',
    ];

    protected $casts = [
        'gender'        => Gender::class,
        'location'      => Location::class,
        'is_onboarding' => 'boolean',
    ];

    public function shifts(): HasMany
    {
        return $this->hasMany(EmployeeShift::class);
    }
}

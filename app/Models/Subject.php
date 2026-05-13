<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// THIS LINE IS THE KEY:
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
protected $fillable = [
    'code',
    'name',
    'units',
    'year_level',
    'semester',
    'pre_req_code',
    'department_id', // Ensure this is here!
    'requirement_id',
    'requirement_type'
];
// app/Models/Subject.php

public function department()
{
    return $this->belongsTo(Department::class);
}
    // Relationship to get the required subject (Pre-req or Co-req)
    public function requirement()
    {
        return $this->belongsTo(Subject::class, 'requirement_id');
    }

    // Now PHP knows exactly what "HasMany" means
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
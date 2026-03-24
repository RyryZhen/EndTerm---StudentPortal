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
    'year_level',     // Added: 1, 2, 3, or 4
    'semester',       // Added: 1 or 2
    'requirement_id', 
    'requirement_type'
];

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
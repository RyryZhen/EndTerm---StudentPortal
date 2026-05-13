<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = ['name', 'department_id', 'year_level'];
    public function schedules() {
    return $this->hasMany(Schedule::class);
}

public function department() {
    return $this->belongsTo(Department::class);
}
}

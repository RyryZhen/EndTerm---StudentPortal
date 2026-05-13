<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{



protected $fillable = [
    'subject_id',
    'section_id',
    'instructor_id',
    'section_name',
    'year_level',
    'semester',
    'day',
    'start_time',
    'end_time',
    'room'
];
    // Get the subject for this schedule
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // Get the instructor for this schedule
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function section() {
    return $this->belongsTo(Section::class);
}
}
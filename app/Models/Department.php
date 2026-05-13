<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code'];

    /**
     * Relationship: A department has many users (students/instructors)
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Relationship: A department has many subjects
     */
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'department_id',
        'employee_id',
        'designation',
        'qualification',
        'salary',
        'joining_date',
        'employment_type',
        'specialization',
        'is_department_head',
        'is_active',
    ];

    protected $casts = [
        'joining_date' => 'date',
        'salary' => 'decimal:2',
        'is_department_head' => 'boolean',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function exams()
    {
        return $this->hasManyThrough(Exam::class, Course::class);
    }

    // Helper Methods
    public function isDepartmentHead()
    {
        return $this->is_department_head || 
               Department::where('head_user_id', $this->user_id)->exists();
    }

    public function getManagedDepartment()
    {
        return Department::where('head_user_id', $this->user_id)->first();
    }
}
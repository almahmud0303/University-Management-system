<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'course_code',
        'description',
        'credits',
        'department_id',
        'teacher_id',
        'academic_year',
        'semester',
        'max_students',
        'type',
        'currency',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'currency' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments')
            ->withPivot('enrollment_date', 'status', 'grade_point', 'letter_grade')
            ->withTimestamps();
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByYear($query, $year)
    {
        return $query->where('academic_year', $year);
    }

    public function scopeBySemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }

    // Helper methods
    public function getEnrolledCountAttribute()
    {
        return $this->enrollments()->where('status', 'enrolled')->count();
    }

    public function getAvailableSlotsAttribute()
    {
        return $this->max_students - $this->enrolled_count;
    }
}
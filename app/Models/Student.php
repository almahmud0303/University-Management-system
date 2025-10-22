<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'department_id',
        'student_id',
        'roll_number',
        'registration_number',
        'session',
        'academic_year',
        'semester',
        'admission_date',
        'hall_id',
        'blood_group',
        'guardian_name',
        'guardian_phone',
        'cgpa',
        'total_credits',
        'completed_credits',
        'status',
        'is_active',
    ];

    protected $casts = [
        'admission_date' => 'date',
        'cgpa' => 'decimal:2',
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

    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrollments')
            ->withPivot('enrollment_date', 'status', 'grade_point', 'letter_grade')
            ->withTimestamps();
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function fees()
    {
        return $this->hasMany(Fee::class);
    }

    public function bookIssues()
    {
        return $this->hasMany(BookIssue::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeGraduated($query)
    {
        return $query->where('status', 'graduated');
    }

    // Helper methods
    public function getFullNameAttribute()
    {
        return $this->user->name;
    }

    public function getEmailAttribute()
    {
        return $this->user->email;
    }
}
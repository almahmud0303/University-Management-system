<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Result extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'exam_id',
        'student_id',
        'marks_obtained',
        'grade',
        'grade_point',
        'remarks',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'grade_point' => 'decimal:2',
            'is_published' => 'boolean',
        ];
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeUnpublished($query)
    {
        return $query->where('is_published', false);
    }

    // Helper methods
    public function getStudentNameAttribute()
    {
        return $this->student->user->name;
    }

    public function getExamTitleAttribute()
    {
        return $this->exam->title;
    }

    public function getPercentageAttribute()
    {
        return ($this->marks_obtained / $this->exam->total_marks) * 100;
    }
}
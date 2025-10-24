<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssignmentSubmission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'assignment_id',
        'student_id',
        'submission_text',
        'file_path',
        'submitted_at',
        'marks',
        'feedback',
        'graded_at',
        'graded_by',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'graded_at' => 'datetime',
        'marks' => 'decimal:2',
    ];

    // Relationships
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function gradedBy()
    {
        return $this->belongsTo(User::class, 'graded_by');
    }

    // Scopes
    public function scopeGraded($query)
    {
        return $query->whereNotNull('marks');
    }

    public function scopeUngraded($query)
    {
        return $query->whereNull('marks');
    }

    public function scopeLate($query)
    {
        return $query->whereColumn('submitted_at', '>', 'assignments.due_date');
    }

    // Helper methods
    public function getIsLateAttribute()
    {
        return $this->submitted_at > $this->assignment->due_date;
    }

    public function getGradeAttribute()
    {
        if (!$this->marks || !$this->assignment->total_marks) {
            return null;
        }

        $percentage = ($this->marks / $this->assignment->total_marks) * 100;

        if ($percentage >= 90) return 'A+';
        if ($percentage >= 85) return 'A';
        if ($percentage >= 80) return 'A-';
        if ($percentage >= 75) return 'B+';
        if ($percentage >= 70) return 'B';
        if ($percentage >= 65) return 'B-';
        if ($percentage >= 60) return 'C+';
        if ($percentage >= 55) return 'C';
        if ($percentage >= 50) return 'C-';
        if ($percentage >= 45) return 'D';
        return 'F';
    }

    public function getGradePointAttribute()
    {
        $grade = $this->grade;
        
        $gradePoints = [
            'A+' => 4.0,
            'A' => 3.75,
            'A-' => 3.5,
            'B+' => 3.25,
            'B' => 3.0,
            'B-' => 2.75,
            'C+' => 2.5,
            'C' => 2.25,
            'C-' => 2.0,
            'D' => 1.0,
            'F' => 0.0,
        ];

        return $gradePoints[$grade] ?? 0.0;
    }

    public function isGraded()
    {
        return !is_null($this->marks);
    }

    public function isLate()
    {
        return $this->submitted_at > $this->assignment->due_date;
    }
}

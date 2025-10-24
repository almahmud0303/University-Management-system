<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'course_id',
        'teacher_id',
        'title',
        'description',
        'due_date',
        'total_marks',
        'file_path',
        'instructions',
        'is_published',
        'created_by',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'total_marks' => 'decimal:2',
        'is_published' => 'boolean',
    ];

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('due_date', '>', now());
    }

    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now());
    }

    // Helper methods
    public function getStatusAttribute()
    {
        if ($this->due_date < now()) {
            return 'overdue';
        } elseif ($this->due_date <= now()->addDays(3)) {
            return 'due_soon';
        } else {
            return 'active';
        }
    }

    public function getSubmissionCountAttribute()
    {
        return $this->submissions()->count();
    }

    public function getAverageScoreAttribute()
    {
        $submissions = $this->submissions()->whereNotNull('marks')->get();
        if ($submissions->count() > 0) {
            return $submissions->avg('marks');
        }
        return 0;
    }

    public function isOverdue()
    {
        return $this->due_date < now();
    }

    public function isDueSoon()
    {
        return $this->due_date <= now()->addDays(3) && $this->due_date > now();
    }
}

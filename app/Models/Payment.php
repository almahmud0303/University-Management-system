<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'course_id',
        'fee_id',
        'amount',
        'payment_method',
        'transaction_id',
        'status',
        'notes',
        'payment_details',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'payment_details' => 'array',
        ];
    }

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function fee()
    {
        return $this->belongsTo(Fee::class);
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByMethod($query, $method)
    {
        return $query->where('payment_method', $method);
    }

    // Helper methods
    public function getStudentNameAttribute()
    {
        return $this->student->user->name;
    }

    public function getFormattedAmountAttribute()
    {
        return 'TK ' . number_format($this->amount, 2);
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('M d, Y');
    }
}
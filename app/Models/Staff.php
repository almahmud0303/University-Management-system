<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'employee_id',
        'designation',
        'department_id',
        'qualification',
        'specialization',
        'salary',
        'joining_date',
        'employment_type',
        'bio',
        'location',
        'is_active',
    ];

    protected $casts = [
        'joining_date' => 'date',
        'salary' => 'decimal:2',
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

    public function bookIssues()
    {
        return $this->hasMany(BookIssue::class);
    }

    public function halls()
    {
        return $this->hasMany(Hall::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
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
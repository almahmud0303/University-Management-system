<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'type',
        'priority',
        'target_role',
        'department_id',
        'publish_date',
        'expiry_date',
        'is_published',
        'is_pinned',
    ];

    protected function casts(): array
    {
        return [
            'publish_date' => 'date',
            'expiry_date' => 'date',
            'is_published' => 'boolean',
            'is_pinned' => 'boolean',
        ];
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeActive($query)
    {
        return $query->where('is_published', true)
                    ->where(function($q) {
                        $q->whereNull('expiry_date')
                          ->orWhere('expiry_date', '>=', now());
                    });
    }

    // Helper methods
    public function getTargetRoleAttribute()
    {
        return $this->target_role ?? 'all';
    }

    public function getIsExpiredAttribute()
    {
        return $this->expiry_date && $this->expiry_date < now();
    }

    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'urgent' => 'red',
            'high' => 'orange',
            'medium' => 'yellow',
            'low' => 'green',
            default => 'gray'
        };
    }
}

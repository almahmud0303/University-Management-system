<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hall extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'description',
        'capacity',
        'facilities',
        'location',
        'type',
        'is_available',
    ];

    protected function casts(): array
    {
        return [
            'facilities' => 'array',
            'is_available' => 'boolean',
        ];
    }

    // Relationships
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Helper methods
    public function getOccupiedCountAttribute()
    {
        return $this->students()->count();
    }

    public function getAvailableCountAttribute()
    {
        return $this->capacity - $this->occupied_count;
    }

    public function getOccupancyPercentageAttribute()
    {
        return ($this->occupied_count / $this->capacity) * 100;
    }

    // Ensure facilities is always an array
    public function getFacilitiesAttribute($value)
    {
        if (is_string($value)) {
            return json_decode($value, true) ?: [];
        }
        return is_array($value) ? $value : [];
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'isbn',
        'author',
        'publisher',
        'publication_year',
        'category',
        'description',
        'total_copies',
        'available_copies',
        'shelf_location',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    public function bookIssues()
    {
        return $this->hasMany(BookIssue::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name',
        'subtitle',
        'suitable_for',
        'description',
        'level',
        'original_price',
        'price',
        'duration',
        'features',
        'is_featured',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'features' => 'array',
        'is_featured' => 'boolean',
    ];

    /**
     * Get the classes for the course.
     */
    public function classes()
    {
        return $this->hasMany(SchoolClass::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    protected $fillable = [
        'class_id',
        'week_number',
        'title',
        'description',
    ];

    /**
     * Get the class that owns this week.
     */
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Get the materials for this week.
     */
    public function materials()
    {
        return $this->hasMany(ClassMaterial::class, 'week_id');
    }

    /**
     * Get the assessments for this week.
     */
    public function assignments()
    {
        return $this->hasMany(Assessment::class, 'week_id');
    }
}

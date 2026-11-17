<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = ['name', 'slug', 'course_code', 'semester', 'description', 'sort_order'];

    public function materials(): HasMany
    {
        return $this->hasMany(CourseMaterial::class);
    }
}

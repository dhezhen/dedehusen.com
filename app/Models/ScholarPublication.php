<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScholarPublication extends Model
{
    protected $fillable = [
        'scholar_profile_id',
        'title',
        'authors',
        'venue',
        'year',
        'citations',
        'scholar_citation_url',
        'is_visible',
    ];

    protected function casts(): array
    {
        return [
            'citations' => 'integer',
            'is_visible' => 'boolean',
        ];
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(ScholarProfile::class, 'scholar_profile_id');
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_visible', true);
    }
}

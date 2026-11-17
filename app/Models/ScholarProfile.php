<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ScholarProfile extends Model
{
    protected $fillable = [
        'scholar_id',
        'author_name',
        'affiliation',
        'citations_all',
        'citations_since',
        'h_index_all',
        'h_index_since',
        'i10_index_all',
        'i10_index_since',
        'citation_history',
        'last_synced_at',
    ];

    protected function casts(): array
    {
        return [
            'citation_history' => 'array',
            'last_synced_at' => 'datetime',
            'citations_all' => 'integer',
            'citations_since' => 'integer',
            'h_index_all' => 'integer',
            'h_index_since' => 'integer',
            'i10_index_all' => 'integer',
            'i10_index_since' => 'integer',
        ];
    }

    public function publications(): HasMany
    {
        return $this->hasMany(ScholarPublication::class);
    }
}

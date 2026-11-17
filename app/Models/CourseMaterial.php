<?php

namespace App\Models;

use App\Models\Concerns\HasPublicationState;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class CourseMaterial extends Model
{
    use HasPublicationState;

    protected $fillable = ['course_id', 'title', 'material_type', 'description', 'resource_type', 'file_path', 'external_url', 'published_at', 'is_published', 'sort_order'];

    protected function casts(): array
    {
        return ['published_at' => 'date', 'is_published' => 'boolean'];
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function resourceUrl(): ?string
    {
        if ($this->resource_type === 'file' && filled($this->file_path)) {
            return Storage::disk('public')->url($this->file_path);
        }

        return $this->external_url;
    }
}

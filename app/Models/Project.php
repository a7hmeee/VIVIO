<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'short_description',
        'client',
        'featured_image',
        'desktop_image',
        'mobile_image',
        'video',
        'problem',
        'solution',
        'approach',
        'result',
        'technologies',
        'year',
        'is_featured',
        'is_published',
        'published_at',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'technologies' => 'array',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'year' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Project $project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });

        static::updating(function (Project $project) {
            if ($project->isDirty('title') && ! $project->isDirty('slug')) {
                $project->slug = Str::slug($project->title);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(ProjectMedia::class)->orderBy('sort_order');
    }

    public function images(): HasMany
    {
        return $this->media()->where('type', 'image')->orderBy('sort_order');
    }

    public function videos(): HasMany
    {
        return $this->media()->where('type', 'video')->orderBy('sort_order');
    }

    public function documents(): HasMany
    {
        return $this->media()->where('type', 'document')->orderBy('sort_order');
    }

    public function team(): BelongsToMany
    {
        return $this->belongsToMany(TeamMember::class, 'project_team_members')
            ->withPivot(['role_on_project', 'contribution_percent'])
            ->withTimestamps();
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('published_at', 'desc');
    }

    public function scopeForYear($query, int $year)
    {
        return $query->where('year', $year);
    }

    public function scopeInCategory($query, $categorySlug)
    {
        return $query->whereHas('category', fn ($q) => $q->where('slug', $categorySlug));
    }

    public function scopeWithTechnologies($query, array $technologies)
    {
        return $query->whereJsonContains('technologies', $technologies);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getTechnologiesListAttribute(): string
    {
        return is_array($this->technologies) ? implode(', ', $this->technologies) : '';
    }
}

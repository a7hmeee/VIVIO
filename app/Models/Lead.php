<?php

namespace App\Models;

use App\Enums\LeadStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property Carbon $created_at
 */
class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company',
        'email',
        'phone',
        'project_type',
        'budget',
        'message',
        'status',
        'source',
    ];

    protected function casts(): array
    {
        return [
            'status' => LeadStatus::class,
        ];
    }

    public function scopeNew(Builder $query): Builder
    {
        return $query->where('status', LeadStatus::New->value);
    }

    public function scopeOfStatus(Builder $query, LeadStatus $status): Builder
    {
        return $query->where('status', $status->value);
    }

    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderByDesc('created_at');
    }

    public function markAs(LeadStatus $status): void
    {
        $this->update(['status' => $status]);
    }
}

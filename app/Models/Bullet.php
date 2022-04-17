<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Bullet extends Model implements Sortable
{
    use HasFactory;
    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'order',
    ];

    protected $guarded = [];

    protected $appends = [
        'complete',
    ];

    protected $casts = [
        'date' => 'date',
        'user_id' => 'integer',
        'order' => 'integer',
    ];

    protected function complete(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $this->state === 'complete',
            set: fn ($value) => [
                'state' => $value ? 'complete' : 'incomplete',
            ],
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }

    public function buildSortQuery(): Builder
    {
        return static::query()->where('collection_id', $this->collection_id);
    }
}

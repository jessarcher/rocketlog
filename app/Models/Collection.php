<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Collection extends Model
{
    use HasFactory;
    use HasHashid;
    use HashidRouting;

    protected $guarded = [];

    protected $appends = [
        'hashid',
    ];

    protected function casts(): array
    {
        return [
            'hide_done' => 'boolean',
            'user_id' => 'integer',
        ];
    }

    protected function name(): Attribute
    {
        return new Attribute(
            set: fn ($value) => [
                'name' => $value,
                'slug' => Str::slug($value),
            ],
        );
    }

    public function bullets(): HasMany
    {
        return $this->hasMany(Bullet::class)
            ->orderBy('order')
            ->orderBy('created_at');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function addBullet($attributes)
    {
        if (is_string($attributes)) {
            $attributes = ['name' => $attributes];
        }

        return $this->bullets()->create(array_merge([
            'type' => 'task',
            'state' => 'incomplete',
            'user_id' => $this->user_id,
        ], $attributes));
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bullet extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = [
        'complete',
    ];

    protected $casts = [
        'date' => 'date',
        'user_id' => 'integer',
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
}

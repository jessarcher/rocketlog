<?php

namespace App\Models;

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

    public function getCompleteAttribute()
    {
        return $this->state === 'complete';
    }

    public function setCompleteAttribute($value)
    {
        $this->attributes['state'] = $value ? 'complete' : 'incomplete';
    }

    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }
}

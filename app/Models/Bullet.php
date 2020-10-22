<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bullet extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = [
        'complete',
    ];

    public function getCompleteAttribute()
    {
        return $this->state === 'complete';
    }

    public function setCompleteAttribute($value)
    {
        $this->attributes['state'] = $value ? 'complete' : 'incomplete';
    }
}

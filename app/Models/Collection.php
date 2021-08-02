<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Collection extends Model
{
    use HasFactory;
    use HasHashid;
    use HashidRouting;

    protected $guarded = [];

    protected $casts = [
        'hide_done' => 'boolean',
        'user_id' => 'integer',
    ];

    protected $appends = [
        'hashid',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function bullets()
    {
        return $this->hasMany(Bullet::class);
    }

    public function users()
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

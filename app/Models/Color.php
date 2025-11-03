<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Color extends Model
{
    protected $fillable = ['name','hex'];

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }
}

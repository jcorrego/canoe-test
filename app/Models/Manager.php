<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Manager extends Model
{
    use HasFactory;

    /**
     * Get the funds for the manager.
     */
    public function funds(): HasMany
    {
        return $this->hasMany(Fund::class);
    }
}

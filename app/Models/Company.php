<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Company extends Model
{
    use HasFactory;

    /**
     * Get the funds for the company.
     */
    public function funds(): BelongsToMany
    {
        return $this->belongsToMany(Fund::class)->withTimestamps();
    }
}

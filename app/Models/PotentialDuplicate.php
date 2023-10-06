<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PotentialDuplicate extends Model
{
    use HasFactory;

    /**
     * Get the Original fund.
     */
    public function originalFund(): BelongsTo
    {
        return $this->belongsTo(Fund::class, 'original_fund_id');
    }

    /**
     * Get the Duplicated fund.
     */
    public function duplicateFund(): BelongsTo
    {
        return $this->belongsTo(Fund::class, 'duplicate_fund_id');
    }
}

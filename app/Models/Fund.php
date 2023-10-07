<?php

namespace App\Models;

use App\Events\DuplicateFundWarning;
use App\Events\FundSaved;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fund extends Model
{
    use HasFactory;

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::created(function (Fund $fund) {
            // Check the created fund, comparing with all other funds with the same manager,
            // If this fund name matches the name or any aliases of the other funds, fire a DuplicateFundWarning event
            $fund->manager->funds->each(function (Fund $otherFund) use ($fund) {
                if ($fund->id === $otherFund->id) {
                    return;
                }
                if (Str::of($fund->name)->lower() === Str::of($otherFund->name)->lower()) {
                    event(new DuplicateFundWarning($fund, $otherFund));
                    return;
                }
                $fund->aliases->each(function (Alias $alias) use ($fund, $otherFund) {
                    if (Str::of($alias->name)->lower() === Str::of($otherFund->name)->lower()) {
                        event(new DuplicateFundWarning($fund, $otherFund));
                        return;
                    }
                });
                $otherFund->aliases->each(function (Alias $alias) use ($fund, $otherFund) {
                    if (Str::of($alias->name)->lower() === Str::of($fund->name)->lower()) {
                        event(new DuplicateFundWarning($fund, $otherFund));
                        return;
                    }
                });
            });
        });
    }

    /**
     * Get the manager that owns the fund.
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(Manager::class);
    }

    /**
     * Get the aliases for the fund.
     */
    public function aliases(): HasMany
    {
        return $this->hasMany(Alias::class);
    }

    /**
     * Get the companies for the fund.
     */
    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class)->withTimestamps();
    }
}

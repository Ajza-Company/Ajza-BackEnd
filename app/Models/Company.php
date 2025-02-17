<?php

namespace App\Models;

use App\Traits\HasLocalized;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, HasLocalized, SoftDeletes;

    /**
     *
     * @return HasOne
     */
    public function localized(): HasOne
    {
        return $this->localizedRelation(CompanyLocale::class);
    }

    /**
     *
     * @return HasMany
     */
    public function stores(): HasMany
    {
        return $this->hasMany(Store::class, 'company_id');
    }

    /**
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {/**/
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     *
     * @return HasManyThrough
     */
    public function usersPivot(): HasManyThrough
    {
        return $this->hasManyThrough(StoreUser::class, Store::class, 'company_id', 'store_id');
    }

    /**
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'store_users', 'store_id', 'user_id')
            ->join('stores', 'stores.id', '=', 'store_users.store_id')
            ->where('stores.company_id', $this->id)
            ->distinct();
    }

    /**
     *
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}

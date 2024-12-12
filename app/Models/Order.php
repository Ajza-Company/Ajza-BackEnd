<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use App\Filters\Supplier\OrdersFilter;
use App\Filters\Supplier\StatisticsFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'store_id',
        'user_id',
        'status'
    ];

    /**
     * Scope a query to only include pending orders
     *
     */
    public function scopeWherePending($query): Builder
    {
        return $query->where('status', OrderStatusEnum::PENDING);
    }

    /**
     * Scope a query to only include pending orders
     *
     */
    public function scopeWhereToday($query): Builder
    {
        return $query->whereDate('created_at', now()->format('Y-m-d'));
    }

    /**
     *
     * @return HasMany
     */
    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }

    /**
     *
     * @return HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(TransactionAttempt::class, 'order_id');
    }

    /**
     *
     * @param Builder $builder
     * @param $request
     * @return Builder
     */
    public function scopeStatisticsFilter(Builder $builder, $request): Builder
    {
        return (new StatisticsFilter($request))->filter($builder);
    }

    /**
     *
     * @param Builder $builder
     * @param $request
     * @return Builder
     */
    public function scopeOrdersFilter(Builder $builder, $request): Builder
    {
        return (new OrdersFilter($request))->filter($builder);
    }
}

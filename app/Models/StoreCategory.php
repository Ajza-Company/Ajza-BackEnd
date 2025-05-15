<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StoreCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'store_id'
    ];

    /**
     *
     * @return HasOne
     */
    public function category(): HasOne
    {
        return $this->hasOne(Category::class, 'category_id');
    }
}

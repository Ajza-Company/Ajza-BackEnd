<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RepOrder extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'image', 'description', 'state_id', 'title'];

    /**
     *
     * @return HasMany
     */
    public function repChats(): HasMany
    {
        return $this->hasMany(RepChat::class, 'rep_order_id');
    }
}

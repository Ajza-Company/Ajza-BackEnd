<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountDeletionRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'requested_at',
        'scheduled_deletion_at',
        'status',
        'reason',
        'cancelled_at',
        'completed_at'
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'scheduled_deletion_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'completed_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeScheduledForDeletion($query)
    {
        return $query->where('status', 'pending')
                    ->where('scheduled_deletion_at', '<=', now());
    }
}

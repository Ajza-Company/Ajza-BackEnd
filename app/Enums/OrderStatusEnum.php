<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 */
final class OrderStatusEnum extends Enum
{
    const PENDING = 'pending';
    const PLACED = 'placed';
    const ACCEPTED = 'accepted';
    const CANCELLED = 'cancelled';
    const REJECTED = 'rejected';
}

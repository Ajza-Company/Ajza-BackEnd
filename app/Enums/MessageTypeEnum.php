<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 */
final class MessageTypeEnum extends Enum
{
    const TEXT = 'text';
    const IMAGE = 'image';
    const OFFER = 'offer';
}

<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 */
final class ErrorMessageEnum extends Enum
{
    const DELETE = 'Unable to delete resource';
    const CREATE = 'Unable to create resource';
    const IMPORT = 'Unable to import resource';
    const VERIFY = 'Unable to verify resource';
    const UPDATE = 'Unable to update resource';
    const CONNECT = 'Unable to connect resource';
    const FIND = 'Unable to find resource';
    const NOTFOUND = 'Resource not found';
    const INITIATE = 'Unable to initiate resource';
    const SERVERERROR = 'Server error';
    const SEND = 'Unable to send resource';
}

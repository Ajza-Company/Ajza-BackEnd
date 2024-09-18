<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 */
final class SuccessMessagesEnum extends Enum
{
    const CREATED = 'Created Successfully';
    const UPDATED = 'Updated Successfully';
    const DELETED = 'Deleted Successfully';
    const IMPORTED = 'Imported Successfully';
    const REQUESTED = 'Requested Successfully';
    const VERIFIED = 'Verified Successfully';
    const LOGGEDOUT = 'LoggedOut Successfully';
    const LOGGEDIN = 'LoggedIn Successfully';
    const REPORTED = 'Reported Successfully';
    const CONNECTED = 'Connected Successfully';
    const FOUND = 'Resource Found';
    const INITIATED = 'Initiated Successfully';
    const SENT = 'Sent Successfully';
}

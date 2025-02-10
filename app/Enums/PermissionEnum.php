<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 */
final class PermissionEnum extends Enum
{
    const SHOW_ALL_PERMISSIONS = 'show-all-permissions';
    const VIEW_ORDERS = 'view-orders';
    const ACCEPT_ORDERS = 'accept-orders';
    const VIEW_OFFERS = 'view-offers';
    const CONTROL_OFFER = 'control-offer';
    const VIEW_USERS = 'view-users';
    const EDIT_USERS = 'edit-users';
    const VIEW_STORES = 'view-stores';
    const EDIT_STORES = 'edit-stores';
    const VIEW_CATEGORIES = 'view-categories';
    const EDIT_CATEGORIES = 'edit-categories';
    const VIEW_PRODUCTS = 'view-products';
    const EDIT_PRODUCTS = 'edit-products';
    const VIEW_ORDERS_STATISTICS = 'view-orders-statistics';
}

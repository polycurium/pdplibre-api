<?php

declare(strict_types=1);

namespace App\Directory\Input;

use App\Directory\Enum\Order;

/**
 * Filtering criteria, at least one is required.
 */
final class SearchSirenSorting
{
    public ?string $field = null;
    public ?Order $order = null;
}

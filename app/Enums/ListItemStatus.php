<?php

namespace App\Enums;

/**
 * Describes the pivot between list and item.
 */
enum ListItemStatus: int
{
    case DEFAULT = 1;
    case CUSTOM = 2;
}

<?php

namespace App\Enums;

enum ListUserStatusEnum: int
{
    case PENDING = 1;
    case ACCEPTED = 2;
    case REJECTED = 3;
    case CANCELLED = 4;
}

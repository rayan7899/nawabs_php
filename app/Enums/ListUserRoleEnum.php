<?php

namespace App\Enums;

enum ListUserRoleEnum: int
{
    case OWNER = 1;
    case EDITOR = 2;
    case VIEWER = 3;
}

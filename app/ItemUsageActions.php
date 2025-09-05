<?php

namespace App;

enum ItemUsageActions: int
{
    case ADD = 1;
    case REMOVE = 2;

    public function label(): string
    {
        return match($this) {
            self::ADD => 'إضافة',
            self::REMOVE => 'إزالة',
        };
    }
}

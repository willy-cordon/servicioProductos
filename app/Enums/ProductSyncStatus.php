<?php

namespace App\Enums;

use BenSampo\Enum\Enum;


final class ProductSyncStatus extends Enum
{
    const pending    = 1;
    const syncing    = 2;
    const synced     = 3;
    const error      = 4;
    const duplicated = 5;
    const rejected   = 6;
}

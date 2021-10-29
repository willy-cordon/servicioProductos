<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ProductSyncAction extends Enum
{
    const create = 1;
    const update = 2;
    const delete = 3;
}

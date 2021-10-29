<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class MLStatus extends Enum
{
    const Active      = 'active';
    const Paused      = 'paused';
    const Closed      = 'closed';
    const UnderReview = 'under_review';
    const Inactive    = 'inactive';
}

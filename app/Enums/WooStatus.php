<?php

namespace App\Enums;

use BenSampo\Enum\Enum;


final class WooStatus extends Enum
{
    const PROCESSING  = 'processing';
    const ONHOLD      = 'on-hold';
    const PENDING     = 'pending';
    const COMPLETED   = 'completed';
    const CANCELLED   = 'cancelled';
    const FAILED      = 'failed';
    const All      = 'all';
}

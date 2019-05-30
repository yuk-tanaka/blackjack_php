<?php

namespace Blackjack\Strategy;

use MyCLabs\Enum\Enum;

class Action extends Enum
{
    private const HIT = 'HIT';

    private const STAND = 'STAND';

    private const DOUBLE = 'DOUBLE';

    private const SURRENDER = 'SURRENDER';
}
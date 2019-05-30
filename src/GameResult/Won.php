<?php

namespace Blackjack\GameResult;

/**
 * Class Won
 * @package Blackjack\GameResult
 */
class Won implements WonInterface
{
    /**
     * @return float
     */
    public function score(): float
    {
        return 1;
    }
}
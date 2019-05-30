<?php

namespace Blackjack\GameResult;

/**
 * Class Draw
 * @package Blackjack\GameResult
 */
class Draw implements GameResultInterface
{
    /**
     * @return float
     */
    public function score(): float
    {
        return 0;
    }
}
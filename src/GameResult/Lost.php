<?php

namespace Blackjack\GameResult;

/**
 * Class Lost
 * @package Blackjack\GameResult
 */
class Lost implements LostInterface
{
    /**
     * @return float
     */
    public function score(): float
    {
        return -1;
    }
}
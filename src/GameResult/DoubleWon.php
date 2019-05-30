<?php

namespace Blackjack\GameResult;

/**
 * Class DoubleWon
 * @package Blackjack\GameResult
 */
class DoubleWon implements DoubleInterface, WonInterface
{
    /**
     * @return float
     */
    public function score(): float
    {
        return 2;
    }
}
<?php

namespace Blackjack\GameResult;

/**
 * Class DoubleLost
 * @package Blackjack\GameResult
 */
class DoubleLost implements DoubleInterface, LostInterface
{
    /**
     * @return float
     */
    public function score(): float
    {
        return -2;
    }
}
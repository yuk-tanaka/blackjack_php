<?php

namespace Blackjack\GameResult;

/**
 * Class Surrender
 * @package Blackjack\GameResult
 */
class Surrender implements LostInterface
{
    /**
     * @return float
     */
    public function score(): float
    {
        return -0.5;
    }
}
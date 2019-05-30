<?php

namespace Blackjack\GameResult;

/**
 * Class BlackjackWon
 * @package Blackjack\GameResult
 */
class BlackjackWon implements WonInterface
{
    /**
     * @return float
     */
    public function score(): float
    {
        return 1.5;
    }
}
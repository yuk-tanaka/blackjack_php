<?php

namespace Blackjack\GameResult;

/**
 * Interface GameResultInterface
 * @package Blackjack\GameResult
 */
interface GameResultInterface
{
    /**
     * @return float
     */
    public function score(): float;
}
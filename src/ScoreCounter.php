<?php

namespace Blackjack;

use Blackjack\GameResult\BlackjackWon;
use Blackjack\GameResult\DoubleInterface;
use Blackjack\GameResult\GameResultInterface;
use Blackjack\GameResult\LostInterface;
use Blackjack\GameResult\Surrender;
use Blackjack\GameResult\WonInterface;

class ScoreCounter
{
    /** @var float */
    private $score = 0;

    /** @var int */
    private $won = 0;

    /** @var int */
    private $lost = 0;

    /** @var int */
    private $blackjack = 0;

    /** @var int */
    private $double = 0;

    /** @var int */
    private $surrender = 0;

    /**
     * @param GameResultInterface $gameResult
     * @return ScoreCounter
     */
    public function add(GameResultInterface $gameResult): self
    {
        $this->score += $gameResult->score();

        if ($gameResult instanceof WonInterface) {
            $this->won++;
        }

        if ($gameResult instanceof LostInterface) {
            $this->lost++;
        }

        if ($gameResult instanceof BlackjackWon) {
            $this->blackjack++;
        }

        if ($gameResult instanceof DoubleInterface) {
            $this->double++;
        }

        if ($gameResult instanceof Surrender) {
            $this->surrender++;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return <<<JSON
{
    "score":"{$this->score}"
    "won":"{$this->won}"
    "lost":"{$this->lost}"
    "blackjack":"{$this->blackjack}"
    "double":"{$this->double}"
    "surrender":"{$this->surrender}"
}

JSON;
    }
}
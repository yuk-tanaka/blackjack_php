<?php

namespace Blackjack;

use Blackjack\PlayingCards\Deck;
use OutOfRangeException;

class Blackjack
{
    /** @var Deck */
    private $deck;

    /** @var ScoreCounter */
    private $scoreCounter;

    /**
     * Blackjack constructor.
     */
    public function __construct()
    {
        $this->deck = new Deck();
        $this->scoreCounter = new ScoreCounter();
    }

    /**
     * @param int $amount
     * @return ScoreCounter
     */
    public function play(int $amount): ScoreCounter
    {
        if ($amount < 1) {
            throw new OutOfRangeException('play $amountが1未満');
        }

        foreach (range(1, $amount) as $i) {
            $game = new Game($this->deck);

            $this->scoreCounter->add($game->play());
        }

        return $this->scoreCounter;
    }
}
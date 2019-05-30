<?php

namespace Blackjack\Player;

use Blackjack\PlayingCards\Deck;
use Blackjack\Strategy\Action;

class Dealer
{
    /** @var Hand */
    private $hand;

    /**
     * Dealer constructor.
     * @param Hand $hand
     */
    public function __construct(Hand $hand)
    {
        $this->hand = $hand;
    }

    /**
     * @param Deck $deck
     * @return Deck
     */
    public function play(Deck $deck): Deck
    {
        while ($this->judgeAction()->equals(Action::HIT())) {
            $this->hand->draw($deck->pop());
        }

        return $deck;
    }

    /**
     * @return Hand
     */
    public function getHand(): Hand
    {
        return $this->hand;
    }

    /**
     * @return Action
     */
    private function judgeAction(): Action
    {
        return $this->hand->calcScore() < 17 ? Action::HIT() : Action::STAND();
    }
}
<?php

namespace Blackjack\Player;

use Blackjack\PlayingCards\Deck;
use Blackjack\Strategy\Action;

class Player
{
    /** @var Hand */
    private $hand;

    /** @var bool */
    private $isDouble = false;

    /** @var bool */
    private $isSurrender = false;

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
     * @param int $upCardNumber
     * @return Deck
     */
    public function play(Deck $deck, int $upCardNumber): Deck
    {
        while (true) {
            $action = $this->judgeAction($upCardNumber);

            if ($action->equals(Action::HIT())) {
                $this->hand->draw($deck->pop());
            }

            if ($action->equals(Action::STAND())) {
                break;
            }

            if ($action->equals(Action::DOUBLE())) {
                $this->isDouble = true;
                $this->hand->draw($deck->pop());
                break;
            }

            if ($action->equals(Action::SURRENDER())) {
                $this->isSurrender = true;
                break;
            }
        }

        return $deck;
    }

    /**
     * @return bool
     */
    public function isDouble(): bool
    {
        return $this->isDouble;
    }

    /**
     * @return bool
     */
    public function isSurrender(): bool
    {
        return $this->isSurrender;
    }

    /**
     * @return Hand
     */
    public function getHand(): Hand
    {
        return $this->hand;
    }

    /**
     * @param int $upCardNumber
     * @return Action
     */
    private function judgeAction(int $upCardNumber): Action
    {
        if ($this->hand->isBust() || $this->hand->isBlackJack()) {
            return Action::STAND();
        }

        if ($this->hand->hasAce()) {
            return $this->judgeWithAce($upCardNumber);
        }

        return $this->judgeWithoutAce($upCardNumber);
    }

    /**
     * aceを持っている場合
     * @param int $upCardNumber
     * @return Action
     */
    private function judgeWithAce(int $upCardNumber): Action
    {
        $score = $this->hand->calcScore();

        if ($score >= 19) {
            return Action::STAND();
        }

        if ($score === 18) {
            //2, 7~8
            if ($upCardNumber === 2 || $upCardNumber === 7 || $upCardNumber === 8) {
                return Action::STAND();
            }
            //9,10,A
            if ($upCardNumber === 1 || $upCardNumber >= 9) {
                return Action::HIT();
            }
            //3~6
            return Action::DOUBLE();
        }

        if ($score === 17) {
            //3~6
            if ($upCardNumber >= 3 && $upCardNumber <= 6) {
                return Action::DOUBLE();
            }

            return Action::HIT();
        }

        //15, 16
        if ($score > 14) {
            //4~6
            if ($upCardNumber >= 4 && $upCardNumber <= 6) {
                return Action::DOUBLE();
            }

            return Action::HIT();
        }

        //14, 13, 12(12A・Aはsplit推奨)
        if ($upCardNumber === 5 || $upCardNumber === 6) {
            return Action::DOUBLE();
        }

        return Action::HIT();
    }

    private function judgeWithoutAce(int $upCardNumber): Action
    {
        $score = $this->hand->calcScore();

        if ($score >= 17) {
            return Action::STAND();
        }

        if ($score === 16) {
            //~6
            if ($upCardNumber !== 1 && $upCardNumber <= 6) {
                return Action::STAND();
            }
            //7,8
            if ($upCardNumber === 7 || $upCardNumber === 8) {
                return Action::HIT();
            }

            return Action::SURRENDER();
        }

        if ($score === 15) {
            //~6
            if ($upCardNumber !== 1 && $upCardNumber <= 6) {
                return Action::STAND();
            }
            //10
            if ($upCardNumber === 10) {
                return Action::SURRENDER();
            }

            return Action::HIT();
        }

        //13, 14
        if ($score >= 13) {
            return ($upCardNumber !== 1 && $upCardNumber<= 6) ? Action::STAND() : Action::HIT();
        }

        if ($score === 12) {
            //4~6
            if ($upCardNumber >= 4 && $upCardNumber <= 6) {
                return Action::STAND();
            }

            return Action::HIT();
        }

        if ($score === 11) {
            return $upCardNumber === 1 ? Action::HIT() : Action::DOUBLE();
        }

        if ($score === 10) {
            return ($upCardNumber === 1 || $upCardNumber === 10) ? Action::HIT() : Action::DOUBLE();
        }

        if ($score === 9) {
            //3~6
            if ($upCardNumber >= 3 && $upCardNumber <= 6) {
                return Action::DOUBLE();
            }

            return Action::HIT();
        }

        //score8以下
        return Action::HIT();
    }
}
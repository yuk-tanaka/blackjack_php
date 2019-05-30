<?php

namespace Blackjack\PlayingCards;

use Tightenco\Collect\Support\Collection;

/**
 * Class Card
 * @package Blackjack\PlayingCards
 */
class Card
{
    /** @var Suit */
    private $suit;

    /** @var Rank */
    private $rank;

    /**
     * Card constructor.
     * @param Suit $suit
     * @param Rank $rank
     */
    public function __construct(Suit $suit, Rank $rank)
    {
        $this->suit = $suit;
        $this->rank = $rank;
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->rank->number();
    }

    /**
     * aceかどうか判定
     * 得点計算はここでは持たない
     * @return bool
     */
    public function isAce(): bool
    {
        return $this->rank->equals(Rank::ACE());
    }

    /**
     * 10, j, q, kならtrue
     * @return bool
     */
    public function is10Score(): bool
    {
        $list = new Collection([Rank::TEN(), Rank::JACK(), Rank::QUEEN(), Rank::KING()]);

        return $list->search($this->rank) !== false;
    }
}
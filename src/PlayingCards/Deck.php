<?php

namespace Blackjack\PlayingCards;

use Tightenco\Collect\Support\Collection;
use OutOfRangeException;

/**
 * Class Deck
 * @package Blackjack\PlayingCards
 * 1deck52枚, ゲームごとに新しいdeckを使用する
 */
class Deck
{
    /** @var Collection */
    private $deck;

    /**
     * Deck constructor.
     */
    public function __construct()
    {
        $this->deck = new Collection();
    }

    /**
     * deckを構築しシャッフルする
     * @return Deck
     */
    public function init(): self
    {
        $deck = new Collection();

        foreach (Suit::values() as $suit) {
            foreach (Rank::values() as $rank) {
                $deck->push(new Card($suit, $rank));
            }
        }

        $this->deck = $deck->shuffle();

        return $this;
    }

    /**
     * deckの最後の要素を返す(Collection::pop() をそのまま使う)
     * @return Card
     * @throws OutOfRangeException
     */
    public function pop(): Card
    {
        if ($this->deck->isEmpty()) {
            throw new OutOfRangeException('deckの中身がempty');
        }

        return $this->deck->pop();
    }
}
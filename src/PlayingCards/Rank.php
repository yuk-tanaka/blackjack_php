<?php

namespace Blackjack\PlayingCards;

use MyCLabs\Enum\Enum;

/**
 * Class Rank
 * @package Blackjack\PlayingCards
 */
class Rank extends Enum
{
    private const ACE = 'A';

    private const TWO = 2;

    private const THREE = 3;

    private const FOUR = 4;

    private const FIVE = 5;

    private const SIX = 6;

    private const SEVEN = 7;

    private const EIGHT = 8;

    private const NINE = 9;

    private const TEN = 10;

    private const JACK = 'J';

    private const QUEEN = 'Q';

    private const KING = 'K';

    /** @var array */
    private $cardNumbers = [
        self::ACE => 1,
        self::JACK => 11,
        self::QUEEN => 12,
        self::KING => 13,
    ];

    /**
     * トランプの数字 Aは1
     * ベーシックストラテジーの条件分岐に使う
     * テストはCardTest
     * @return int
     */
    public function number(): int
    {
        return $this->cardNumbers[$this->getValue()] ?? $this->value;
    }
}
<?php

namespace BlackJack;

use Blackjack\PlayingCards\Card;
use Blackjack\PlayingCards\Rank;
use Blackjack\PlayingCards\Suit;
use PHPUnit\Framework\TestCase;

class CardTest extends TestCase
{
    /**
     * @dataProvider isAceProvider
     * @param Suit $suit
     * @param Rank $rank
     * @param bool $expected
     */
    public function testIsAce(Suit $suit, Rank $rank, bool $expected)
    {
        $card = new Card($suit, $rank);

        $this->assertEquals($expected, $card->isAce());
    }

    /**
     * @dataProvider is10ScoreProvider
     * @param Suit $suit
     * @param Rank $rank
     * @param bool $expected
     */
    public function testIs10Score(Suit $suit, Rank $rank, bool $expected)
    {
        $card = new Card($suit, $rank);

        $this->assertEquals($expected, $card->is10Score());
    }

    /**
     * @dataProvider getNumberProvider
     * @param Suit $suit
     * @param Rank $rank
     * @param int $expected
     */
    public function testGetNumber(Suit $suit, Rank $rank, int $expected)
    {
        $card = new Card($suit, $rank);

        $this->assertEquals($expected, $card->getNumber());
    }

    /**
     * @return array
     */
    public function isAceProvider(): array
    {
        return [
            [Suit::SPADE(), Rank::ACE(), true],
            [Suit::SPADE(), Rank::TWO(), false],
        ];
    }

    /**
     * @return array
     */
    public function is10ScoreProvider(): array
    {
        return [
            [Suit::SPADE(), Rank::TEN(), true],
            [Suit::SPADE(), Rank::JACK(), true],
            [Suit::SPADE(), Rank::QUEEN(), true],
            [Suit::SPADE(), Rank::KING(), true],
            [Suit::SPADE(), Rank::ACE(), false],
        ];
    }

    /**
     * @return array
     */
    public function getNumberProvider(): array
    {
        return [
            [Suit::SPADE(), Rank::ACE(), 1],
            [Suit::SPADE(), Rank::TWO(), 2],
            [Suit::SPADE(), Rank::JACK(), 11],
            [Suit::SPADE(), Rank::QUEEN(), 12],
            [Suit::SPADE(), Rank::KING(), 13],
        ];
    }
}
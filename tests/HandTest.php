<?php

namespace BlackJack;

use Blackjack\Player\Hand;
use Blackjack\PlayingCards\Card;
use Blackjack\PlayingCards\Rank;
use Blackjack\PlayingCards\Suit;
use PHPUnit\Framework\TestCase;

class HandTest extends TestCase
{
    /**
     * @dataProvider CalcScoreProvider
     * @param Card $first
     * @param Card $second
     * @param array $adds
     * @param integer $expected
     */
    public function testCalcScore(Card $first, Card $second, array $adds, int $expected)
    {
        $hand = new Hand($first, $second);

        foreach ($adds as $card) {
            $hand->draw($card);
        }

        $this->assertEquals($expected, $hand->calcScore());
    }

    /**
     * @dataProvider hasAceProvider
     * @param Card $first
     * @param Card $second
     * @param bool $expected
     */
    public function testHasAce(Card $first, Card $second, bool $expected)
    {
        $hand = new Hand($first, $second);

        $this->assertEquals($expected, $hand->hasAce());
    }

    /**
     * @dataProvider isBlackjackProvider
     * @param Card $first
     * @param Card $second
     * @param bool $expected
     */
    public function testIsBlackjack(Card $first, Card $second, bool $expected)
    {
        $hand = new Hand($first, $second);

        $this->assertEquals($expected, $hand->isBlackJack());
    }

    /**
     * @dataProvider IsBustProvider
     * @param Card $first
     * @param Card $second
     * @param array $adds
     * @param bool $expected
     */
    public function testIsBust(Card $first, Card $second, array $adds, bool $expected)
    {
        $hand = new Hand($first, $second);

        foreach ($adds as $card) {
            $hand->draw($card);
        }

        $this->assertEquals($expected, $hand->isBust());
    }

    /**
     * @return array
     */
    public function calcScoreProvider(): array
    {
        $ace = new Card(Suit::SPADE(), Rank::ACE());
        $king = new Card(Suit::SPADE(), Rank::KING());
        $two = new Card(Suit::SPADE(), Rank::TWO());

        return [
            [$ace, $king, [], 21],
            [$ace, $two, [], 13],
            [$ace, $ace, [], 12],
            [$king, $king, [], 20],
            [$ace, $ace, [$ace], 13],
            [$king, $king, [$ace], 21],
            [$ace, $ace, [$ace, $ace], 14],
            [$ace, $ace, [$ace, $king], 23],
            [$king, $king, [$king, $king, $king, $king, $king, $king, $king, $king], 100],
        ];
    }

    /**
     * @return array
     */
    public function hasAceProvider(): array
    {
        $ace = new Card(Suit::SPADE(), Rank::ACE());
        $king = new Card(Suit::SPADE(), Rank::KING());
        $ten = new Card(Suit::SPADE(), Rank::TEN());
        $two = new Card(Suit::SPADE(), Rank::TWO());

        return [
            [$ace, $king, true],
            [$king, $ace, true],
            [$ace, $ten, true],
            [$ace, $two, true],
            [$ace, $ace, true],
            [$king, $king, false],
            [$two, $two, false],
            [$king, $two, false],
        ];
    }

    /**
     * @return array
     */
    public function isBlackjackProvider(): array
    {
        $ace = new Card(Suit::SPADE(), Rank::ACE());
        $king = new Card(Suit::SPADE(), Rank::KING());
        $ten = new Card(Suit::SPADE(), Rank::TEN());
        $two = new Card(Suit::SPADE(), Rank::TWO());

        return [
            [$ace, $king, true],
            [$king, $ace, true],
            [$ace, $ten, true],
            [$ace, $two, false],
            [$ace, $ace, false],
            [$king, $king, false],
            [$two, $two, false],
            [$king, $two, false],
        ];
    }

    /**
     * @return array
     */
    public function isBustProvider(): array
    {
        $ace = new Card(Suit::SPADE(), Rank::ACE());
        $king = new Card(Suit::SPADE(), Rank::KING());
        $two = new Card(Suit::SPADE(), Rank::TWO());

        return [
            [$ace, $king, [], false],
            [$ace, $two, [], false],
            [$ace, $ace, [], false],
            [$king, $king, [], false],
            [$ace, $ace, [$ace], false],
            [$king, $king, [$ace], false],
            [$ace, $ace, [$ace, $ace], false],
            [$ace, $ace, [$ace, $king], true],
            [$king, $king, [$king, $king, $king, $king, $king, $king, $king, $king], true],
        ];
    }
}
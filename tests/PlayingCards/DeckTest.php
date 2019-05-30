<?php

namespace BlackJack;

use Blackjack\PlayingCards\Card;
use Blackjack\PlayingCards\Deck;
use PHPUnit\Framework\TestCase;
use OutOfRangeException;

class DeckTest extends TestCase
{
    public function testDraw()
    {
        $deck = (new Deck())->init();

        $this->assertInstanceOf(Card::class, $deck->pop());
    }

    public function testDrawException()
    {
        $this->expectException(OutOfRangeException::class);

        (new Deck())->pop();
    }
}
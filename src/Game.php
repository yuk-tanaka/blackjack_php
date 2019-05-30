<?php

namespace Blackjack;

use Blackjack\GameResult\GameResultInterface;
use Blackjack\Player\Dealer;
use Blackjack\Player\Hand;
use Blackjack\Player\Player;
use Blackjack\PlayingCards\Deck;

/**
 * Class Game
 * @package Blackjack
 */
class Game
{
    /** @var Deck */
    private $deck;

    /** @var Player */
    private $player;

    /** @var Dealer */
    private $dealer;

    /**
     * Game constructor.
     * @param Deck $deck
     */
    public function __construct(Deck $deck)
    {
        $this->deck = $deck;
    }

    /**
     * @return GameResultInterface
     */
    public function play(): GameResultInterface
    {
        $this->deck->init();

        $this->player = new Player($this->buildHand());
        $this->dealer = new Dealer($this->buildHand());

        $this->deck = $this->player->play($this->deck, $this->dealer->getHand()->upCardNumber());

        //playerだけで結果確定する場合はdealer playなしで終了
        if ($result = GameJudge::judge($this->player)) {
            return $result;
        }

        $this->deck = $this->dealer->play($this->deck);

        return GameJudge::judge($this->player, $this->dealer);
    }

    /**
     * @return Hand
     */
    private function buildHand(): Hand
    {
        return new Hand($this->deck->pop(), $this->deck->pop());
    }
}
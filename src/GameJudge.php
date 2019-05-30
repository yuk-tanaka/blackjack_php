<?php

namespace Blackjack;

use Blackjack\GameResult\BlackjackWon;
use Blackjack\GameResult\DoubleLost;
use Blackjack\GameResult\DoubleWon;
use Blackjack\GameResult\Draw;
use Blackjack\GameResult\GameResultInterface;
use Blackjack\GameResult\Lost;
use Blackjack\GameResult\Surrender;
use Blackjack\GameResult\Won;
use Blackjack\Player\Dealer;
use Blackjack\Player\Player;

/**
 * Static GameResultを返す
 * Class GameJudge
 * @package Blackjack
 */
class GameJudge
{
    /**
     * @param Player $player
     * @param Dealer|null $dealer
     * @return GameResultInterface|null
     */
    static public function judge(Player $player, ?Dealer $dealer = null): ?GameResultInterface
    {
        return is_null($dealer) ? self::playerJudge($player) : self::finalJudge($player, $dealer);
    }

    /**
     * playerターン終了時に判定
     * 決着つかない場合はnull
     * @param Player $player
     * @return GameResultInterface|null
     */
    static private function playerJudge(Player $player): ?GameResultInterface
    {
        if ($player->getHand()->isBust()) {
            return $player->isDouble() ? new DoubleLost() : new Lost();
        }

        if ($player->getHand()->isBlackJack()) {
            return new BlackjackWon();
        }

        if ($player->isSurrender()) {
            return new Surrender();
        }

        return null;
    }

    /**
     * @param Player $player
     * @param Dealer $dealer
     * @return GameResultInterface
     */
    static private function finalJudge(Player $player, Dealer $dealer): GameResultInterface
    {
        //dealer bust
        if ($dealer->getHand()->isBust()) {
            return $player->isDouble() ? new DoubleWon() : new Won();
        }

        $comparison = $player->getHand()->calcScore() - $dealer->getHand()->calcScore();

        if ($comparison > 0) {
            return $player->isDouble() ? new DoubleWon() : new Won();
        }

        if ($comparison < 0) {
            return $player->isDouble() ? new DoubleLost() : new Lost();
        }

        return new Draw();
    }

}
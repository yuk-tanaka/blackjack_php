<?php

namespace Blackjack\Player;

use Blackjack\PlayingCards\Card;
use Tightenco\Collect\Support\Collection;
use OutOfRangeException;

/**
 * Class Hand
 * @package Blackjack\Player
 */
class Hand
{
    /** @var Collection Card[] */
    private $cards;

    /**
     * Hand constructor.
     * @param Card $first
     * @param Card $second
     */
    public function __construct(Card $first, Card $second)
    {
        $this->cards = new Collection();

        $this->cards->push($first);
        $this->cards->push($second);
    }

    /**
     * @return Collection Card[]
     */
    public function getCards(): Collection
    {
        return $this->cards;
    }

    /**
     * @return int
     */
    public function upCardNumber(): int
    {
        return $this->cards[0]->getNumber();
    }


    /**
     * @param Card $card
     */
    public function draw(Card $card): void
    {
        $this->cards->push($card);
    }

    /**
     * 得点を数える
     * aceは11で数えてbustしないなら11点とする
     * @return int
     */
    public function calcScore(): int
    {
        $aceCount = 0;
        $score = 0;

        /** @var Card $card */
        foreach ($this->cards as $card) {
            //aceは後のwhileで数える
            if ($card->isAce()) {
                $aceCount++;
                continue;

            } elseif ($card->is10Score()) {
                $score += 10;
            } else {
                //valueはint|string 2~9ならそのまま足してよい
                $score += $card->getNumber();
            }
        }

        while ($aceCount) {
            //自分のカード以外で11点以上なら1点、10点以下なら11点として数える
            if ($score >= 11) {
                $score++;
            } else {
                $score += 11;
            }
            $aceCount--;
        }

        return $score;
    }

    /**
     * @return bool
     */
    public function isAdded(): bool
    {
        return $this->cards->count() > 2;
    }

    /**
     * @return bool
     */
    public function hasAce(): bool
    {
        /** @var Card $card */
        foreach ($this->cards as $card) {
            if ($card->isAce()) {
                return true;
            }
        }

        return false;
    }

    /**
     * 初期手札で10とAの組み合わせならtrue
     * @return bool
     */
    public function isBlackJack(): bool
    {
        if ($this->cards->count() > 2) {
            return false;
        }

        if (!$this->hasAce()) {
            return false;
        }

        $has10 = false;

        /** @var Card $card */
        foreach ($this->cards as $card) {
            if ($card->isAce()) {
                continue;
            } elseif ($card->is10Score() && !$has10) {
                $has10 = true;
            } else {
                return false;
            }
        }

        return $has10;
    }

    /**
     * @return bool
     */
    public function isBust(): bool
    {
        return $this->calcScore() > 21;
    }
}
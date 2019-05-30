<?php

require './vendor/autoload.php';

echo (new \Blackjack\Blackjack())->play(10000)->render();
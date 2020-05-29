<?php declare(strict_types=1);

namespace RopaporsBot;

class TheBot
{
    const WIN_TEXT = 'YOU WIN!';
    const TIE_TEXT = 'it\'s a tie';
    const LOSE_TEXT = 'YOU LOSE :(';
    const ROCK = 'rock';
    const PAPER = 'paper';
    const SCISSORS = 'scissors';

    const ROCK_EMOJI = "🗿";
    const PAPER_EMOJI = "🧻️";
    const SCISSORS_EMOJI = "✂️";

    public string $name = 'RopaporsBot';
    private Randomizer $randomizer;

    public function __construct(Randomizer $randomizer)
    {
        $this->randomizer = $randomizer;
    }

    public function play(string $playerPlays): string
    {
        $playerPlays = strtolower($playerPlays);
        $validMoves = [self::ROCK, self::PAPER, self::SCISSORS];

        if (!in_array($playerPlays, $validMoves)) {
            throw new \InvalidArgumentException("$playerPlays is not a valid move");
        }
        // we know we have a valid move to work with

        $botPlays = $validMoves[$this->randomizer->randomMeUp(count($validMoves) - 1)];

        $resultText = '';

        if ($playerPlays === $botPlays) {
            $resultText = self::TIE_TEXT;
        }

        if (
                $playerPlays === self::ROCK && $botPlays === self::PAPER
            ||  $playerPlays === self::PAPER && $botPlays === self::SCISSORS
            ||  $playerPlays === self::SCISSORS && $botPlays === self::ROCK
        ) {
            $resultText = self::LOSE_TEXT;
        }

        if (
                $playerPlays === self::ROCK && $botPlays === self::SCISSORS
            ||  $playerPlays === self::PAPER && $botPlays === self::ROCK
            ||  $playerPlays === self::SCISSORS && $botPlays === self::PAPER
        ) {
            $resultText = self::WIN_TEXT;
        }

        $playerEmoji = constant( 'self::' . strtoupper($playerPlays) . '_EMOJI');
        $botEmoji = constant('self::' . strtoupper($botPlays) . '_EMOJI');

        return "You played {$playerEmoji} and RopaporsBot played {$botEmoji} -- {$resultText}";
    }
}

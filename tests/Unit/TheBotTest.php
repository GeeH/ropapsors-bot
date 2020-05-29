<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use RopaporsBot\Randomizer;
use RopaporsBot\TheBot;


beforeEach(function () {
    $this->theBot = new TheBot(new \RopaporsBot\Randomizer());
});

it('errors if we play a move that isn\'t valid', function () {
    $this->theBot->play('cat');
})->throws(InvalidArgumentException::class);

it('returns correct emoji in the result when we play a valid move', function ($stringMove, $emojiMove) {
    $result = $this->theBot->play($stringMove);
    assertStringContainsString('You played ' . $emojiMove, $result);
})->with([
    [TheBot::ROCK, TheBot::ROCK_EMOJI],
    [TheBot::SCISSORS, TheBot::SCISSORS_EMOJI],
    [TheBot::PAPER, TheBot::PAPER_EMOJI],
]);

it('returns a valid result with a random move from the bot',
    function ($myMove, $botMoveIndex, $expectResult) {
        /** @var TestCase $this */
        $randomizerMock = $this->getMockBuilder(Randomizer::class)
            ->getMock();

        $randomizerMock->expects($this->once())
            ->method('randomMeUp')
            ->with(2)
            ->willReturn($botMoveIndex);

        $theBot = new TheBot($randomizerMock);

        assertEquals($expectResult, $theBot->play($myMove));
    })->with([
    [TheBot::ROCK, 0, 'You played ' . TheBot::ROCK_EMOJI . ' and RopaporsBot played ' . TheBot::ROCK_EMOJI . ' -- it\'s a tie'],
    [TheBot::PAPER, 1, 'You played ' . TheBot::PAPER_EMOJI . ' and RopaporsBot played ' . TheBot::PAPER_EMOJI . ' -- it\'s a tie'],
    [TheBot::SCISSORS, 2, 'You played ' . TheBot::SCISSORS_EMOJI . ' and RopaporsBot played ' . TheBot::SCISSORS_EMOJI . ' -- it\'s a tie'],
    [TheBot::ROCK, 1, 'You played ' . TheBot::ROCK_EMOJI . ' and RopaporsBot played ' . TheBot::PAPER_EMOJI . ' -- YOU LOSE :('],
    [TheBot::ROCK, 2, 'You played ' . TheBot::ROCK_EMOJI . ' and RopaporsBot played ' . TheBot::SCISSORS_EMOJI . ' -- YOU WIN!'],
    [TheBot::PAPER, 0, 'You played ' . TheBot::PAPER_EMOJI . ' and RopaporsBot played ' . TheBot::ROCK_EMOJI . ' -- YOU WIN!'],
    [TheBot::PAPER, 2, 'You played ' . TheBot::PAPER_EMOJI . ' and RopaporsBot played ' . TheBot::SCISSORS_EMOJI . ' -- YOU LOSE :('],
    [TheBot::SCISSORS, 0, 'You played ' . TheBot::SCISSORS_EMOJI . ' and RopaporsBot played ' . TheBot::ROCK_EMOJI . ' -- YOU LOSE :('],
    [TheBot::SCISSORS, 1, 'You played ' . TheBot::SCISSORS_EMOJI . ' and RopaporsBot played ' . TheBot::PAPER_EMOJI . ' -- YOU WIN!']
]);

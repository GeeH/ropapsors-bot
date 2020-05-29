<?php declare(strict_types=1);

namespace RopaporsBot;

class Randomizer
{
    public function randomMeUp(int $maxValue): int
    {
        return \random_int(0, $maxValue);
    }
}

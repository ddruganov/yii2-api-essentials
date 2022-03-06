<?php

namespace tests\unit;

use Faker\Factory;
use Faker\Generator;

trait UseFaker
{
    private Generator $generator;

    protected function faker(): Generator
    {
        return $this->generator ??= Factory::create();
    }
}

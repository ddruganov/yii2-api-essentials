<?php

namespace ddruganov\Yii2ApiEssentials\testing\traits;

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

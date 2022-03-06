<?php

namespace ddruganov\Yii2ApiEssentials\exceptions;

use Exception;

class NotImplementedException extends Exception
{
    public function __construct(string $feature)
    {
        parent::__construct("$feature is not yet implemented");
    }
}

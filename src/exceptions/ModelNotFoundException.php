<?php

namespace ddruganov\Yii2ApiEssentials\exceptions;

use Exception;

class ModelNotFoundException extends Exception
{
    public function __construct(string $modelClass)
    {
        parent::__construct("Database search for $modelClass failed");
    }
}

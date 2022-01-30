<?php

namespace ddruganov\Yii2ApiEssentials\exceptions;

use Exception;

class ModelNotFoundException extends Exception
{
    public function __construct(string $modelClass)
    {
        parent::__construct("Модель $modelClass не найдена");
    }
}

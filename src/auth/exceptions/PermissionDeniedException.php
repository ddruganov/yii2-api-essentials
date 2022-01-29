<?php

namespace ddruganov\Yii2ApiEssentials\auth\exeptions;

use Exception;

class PermissionDeniedException extends Exception
{
    public function __construct()
    {
        parent::__construct('Отказано в доступе');
    }
}

<?php

namespace src\auth\http\actions;

use src\common\http\actions\ApiAction;
use Yii;

class RefreshAction extends ApiAction
{
    public function run()
    {
        $refreshToken = $this->getData('refreshToken');

        return Yii::$app->get('auth')->refresh($refreshToken);
    }
}

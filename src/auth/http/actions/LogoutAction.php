<?php

namespace src\auth\http\actions;

use src\common\http\actions\ApiAction;
use Yii;

class LogoutAction extends ApiAction
{
    public function run()
    {
        return Yii::$app->get('auth')->logout();
    }
}

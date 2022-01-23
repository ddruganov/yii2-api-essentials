<?php

namespace src\auth\http\filters;

use src\common\ExecutionResult;
use Yii;
use yii\base\ActionFilter;

class AuthFilter extends ActionFilter
{
    public array $except = [];

    public function beforeAction($action)
    {
        if (in_array(Yii::$app->controller->action->id, $this->except)) {
            return parent::beforeAction($action);
        }

        if (Yii::$app->get('auth')->verify()) {
            return parent::beforeAction($action);
        }

        Yii::$app->getResponse()->data = ExecutionResult::exception('Ваша авторизация недействительна');
        Yii::$app->getResponse()->setStatusCode(401);
        Yii::$app->end();
    }
}

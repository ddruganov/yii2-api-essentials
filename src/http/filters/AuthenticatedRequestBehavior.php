<?php

namespace src\http\filters;

use src\ExecutionResult;
use Yii;
use yii\base\Behavior;
use yii\base\Controller;

class AuthenticatedRequestBehavior extends Behavior
{
    public array $except = [];

    public function events(): array
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction',
        ];
    }

    public function beforeAction()
    {
        if (in_array(Yii::$app->controller->action->id, $this->except)) {
            return;
        }

        if (Yii::$app->get('auth')->verify()) {
            return;
        }

        Yii::$app->getResponse()->data = ExecutionResult::exception('Ваша авторизация недействительна');
        Yii::$app->getResponse()->setStatusCode(401);
        Yii::$app->end();
    }
}

<?php

namespace src\auth\http\actions;

use src\auth\models\forms\LoginForm;
use src\common\ExecutionResult;
use src\common\http\actions\ApiAction;
use Yii;

class LoginAction extends ApiAction
{
    public function run()
    {
        $loginForm = $this->getLoginForm();
        $loginForm->setAttributes($this->getData());
        if (!$loginForm->validate()) {
            return ExecutionResult::failure($loginForm->getFirstErrors());
        }

        return Yii::$app->get('auth')->login($loginForm->getUser());
    }

    private function getLoginForm(): LoginForm
    {
        $loginFormClass = Yii::$app->params['authentication']['loginForm'] ?? LoginForm::class;
        return new $loginFormClass;
    }
}

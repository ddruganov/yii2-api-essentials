<?php

namespace src\http\filters;

use Yii;
use yii\base\Behavior;
use yii\base\Controller;

class TimerBehavior extends Behavior
{
    private float $startTime = 0.0;

    public function events(): array
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction',
            Controller::EVENT_AFTER_ACTION => 'afterAction',
        ];
    }

    public function beforeAction()
    {
        $this->startTime = microtime(true);
    }

    public function afterAction()
    {
        $method = Yii::$app->getRequest()->getMethod();
        $uri = Yii::$app->getRequest()->getUrl();
        $delta = microtime(true) - $this->startTime;
        Yii::debug("$method $uri took $delta seconds");
    }
}

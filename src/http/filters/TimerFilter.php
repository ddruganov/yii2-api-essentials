<?php

namespace ddruganov\Yii2ApiEssentials\http\filters;

use Yii;
use yii\base\ActionFilter;

class TimerFilter extends ActionFilter
{
    private float $startTime = 0.0;

    public function beforeAction($action)
    {
        $this->startTime = microtime(true);

        return parent::beforeAction($action);
    }

    public function afterAction($action, $result)
    {
        $method = Yii::$app->getRequest()->getMethod();
        $url = Yii::$app->getRequest()->getUrl();
        $delta = microtime(true) - $this->startTime;
        Yii::debug("$method $url took $delta seconds");

        return parent::afterAction($action, $result);
    }
}

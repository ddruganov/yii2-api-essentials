<?php

namespace ddruganov\Yii2ApiEssentials\common\http\controllers;

use ddruganov\Yii2ApiEssentials\common\http\filters\TimerBehavior;
use ddruganov\Yii2ApiEssentials\common\http\filters\TransactionFilter;
use Yii;
use yii\base\Controller;
use yii\web\Response;

class ApiController extends Controller
{
    public function behaviors()
    {
        return [TimerBehavior::class, TransactionFilter::class];
    }

    public function init()
    {
        Yii::$app->getResponse()->format = Response::FORMAT_JSON;

        parent::init();
    }
}

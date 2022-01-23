<?php

namespace src\common\http\controllers;

use src\http\filters\TimerBehavior;
use src\http\filters\TransactionFilter;
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

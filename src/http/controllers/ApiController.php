<?php

namespace ddruganov\Yii2ApiEssentials\http\controllers;

use ddruganov\Yii2ApiEssentials\http\filters\TimerFilter;
use ddruganov\Yii2ApiEssentials\http\filters\TransactionFilter;
use Yii;
use yii\base\Controller;
use yii\web\Response;

abstract class ApiController extends Controller
{
    public function behaviors()
    {
        return [
            'timer' => TimerFilter::class,
            'transaction' => TransactionFilter::class
        ];
    }

    public function init()
    {
        Yii::$app->getResponse()->format = Response::FORMAT_JSON;

        parent::init();
    }
}

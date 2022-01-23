<?php

namespace src\http;

use src\http\filters\TimerBehavior;
use src\http\filters\TransactionFilter;
use yii\base\Controller;

class ApiController extends Controller
{
    public function behaviors()
    {
        return [TimerBehavior::class, TransactionFilter::class];
    }
}

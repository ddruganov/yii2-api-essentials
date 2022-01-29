<?php

namespace ddruganov\Yii2ApiEssentials\auth\http\controllers;

use ddruganov\Yii2ApiEssentials\auth\http\filters\AuthFilter;
use ddruganov\Yii2ApiEssentials\common\http\controllers\ApiController;

class SecureApiController extends ApiController
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'authenticated-request' => [
                    'class' => AuthFilter::class,
                    'except' => ['login', 'refresh']
                ],
            ]
        );
    }
}

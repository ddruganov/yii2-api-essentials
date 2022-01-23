<?php

namespace src\auth\http\controllers;

use src\auth\http\filters\AuthFilter;
use src\common\http\controllers\ApiController;

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

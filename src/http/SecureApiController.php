<?php

namespace src\http;

use src\http\filters\AuthenticatedRequestBehavior;

class SecureApiController extends ApiController
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'authenticated-request' => [
                    'class' => AuthenticatedRequestBehavior::class,
                    'except' => ['login', 'refresh']
                ],
            ]
        );
    }
}

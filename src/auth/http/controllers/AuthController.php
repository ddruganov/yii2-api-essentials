<?php

namespace src\auth\http\controllers;

use src\auth\http\actions\LoginAction;
use src\auth\http\actions\LogoutAction;
use src\auth\http\actions\RefreshAction;
use src\auth\http\filters\RbacFilter;

class AuthController extends SecureApiController
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'allow' => [
                    'class' => RbacFilter::class,
                    'rules' => [
                        'login' => 'authenticate',
                        'refresh' => 'authenticate',
                        'logout' => 'authenticate',
                    ]
                ]
            ]
        );
    }

    public function actions()
    {
        return [
            'login' => LoginAction::class,
            'refresh' => RefreshAction::class,
            'logout' => LogoutAction::class,
        ];
    }
}

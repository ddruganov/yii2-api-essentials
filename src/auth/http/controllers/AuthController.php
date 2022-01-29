<?php

namespace ddruganov\Yii2ApiEssentials\auth\http\controllers;

use ddruganov\Yii2ApiEssentials\auth\http\actions\LoginAction;
use ddruganov\Yii2ApiEssentials\auth\http\actions\LogoutAction;
use ddruganov\Yii2ApiEssentials\auth\http\actions\RefreshAction;
use ddruganov\Yii2ApiEssentials\auth\http\filters\RbacFilter;

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

<?php

use yii\db\Connection;

return [
    'id' => 'test',
    'basePath' => Yii::getAlias('@tests'),
    'components' => [
        'db' => [
            'class' => Connection::class,
            'dsn' => 'pgsql:host=yii2.api.essentials.db;dbname=yii2apiessentials',
            'username' => 'admin',
            'password' => 'admin',
            'charset' => 'utf8',
            'enableSchemaCache' => false,
        ]
    ]
];

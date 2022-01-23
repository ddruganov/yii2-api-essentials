# yii2-api-essentials

Bunch of small components to make one's development life eaiser

## Installation

`composer require ddruganov/yii2-api-essentials`

## Auth module

1. Add this to your app's params config:

```php
...
    'authentication' => [
        'loginForm' => LoginForm::class, // default is ddruganov\Yii2ApiEssentials\auth\models\forms\LoginForm
        'masterPassword' => [
            'enable' => true,
            'value' => ''
        ],
        'tokens' => [
            'secret' => '',
            'access' => [
                'ttl' => 0, // seconds
                'issuer' => '',
                'audience' => ''
            ],
            'refresh' => [
                'ttl' => 0 // seconds
            ]
        ]
    ]
...
```

2. Install the `AuthController` in your api app main config
3. Install the `AuthComponent` in you api app main config to reach it as `Yii::$app->get('auth')`
4. Login in via `auth/login`
5. Get a fresh pair of token via `auth/refresh` by POSTing a currently valid refresh token
6. Logout via `auth/logout`

Use `Yii::$app->get('auth')->getCurrentUser()` to get the currently logged in `ddruganov\Yii2ApiEssentials\auth\models\User`

## Common module

Contains useful classes (filters, behaviors, helpers, etc) for api development:

1. `TimestampBehavior`: provides basic timestamping of an active record model with fields being 'created_at' and 'updated_at' (detects their existence automatically)
2. `ModelNotFoundException`: for some reason this is not found in yii2
3. `ApiAction`: provides a way to get all incoming data as one array
4. `ApiController`: returns everything as json, measure every request timing and makes all api calls transactional
5. `TimerFilter`: measure the time that an action takes and dumps into the debug log
6. `TransactionFilter`: starts transaction before action, ends it after action; depends on `ExecutionResult` being successful
7. `DateHelper`: bunch of useful methods for date manipulation
8. `ExecutionResult`: basically a statically typed version of an array with a specific structure to ensure that all api methods return the same structure, but not limitied to that

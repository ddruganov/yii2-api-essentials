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

- `behaviors\TimestampBehavior`: provides basic timestamping of an active record model with fields being 'created_at' and 'updated_at' (detects their existence automatically)
- `collectors\AbstractDataCollector`: a convient way to collect data for an api call
- `exceptions\ModelNotFoundException`: for some reason this is not found in yii2
- `http\actions\ApiAction`: base class for all api actions that provides a way to get all incoming data as one array
- `http\actions\ApiModelAction`: provides a way to separate validation and saving of models from the ActiveRecord class to reduce class bloat
- `http\actions\ClosureAction`: when the `ApiModelAction` is overkill
- `http\actions\CollectorAction`: give it a collector and it will return the collected data as an `ExecutionResult`
- `http\controllers\ApiController`: returns everything as json, measure every request timing and makes all api calls transactional
- `http\filters\TimerFilter`: measure the time that an action takes and dumps into the debug log
- `http\filters\TransactionFilter`: starts transaction before action, ends it after action; depends on `ExecutionResult` being successful
- `models\AbstractApiModel`: used in the `ApiModelAction`
- `DateHelper`: bunch of useful methods for date manipulation
- `ExecutionResult`: basically a statically typed version of an array with a specific structure to ensure that all api methods return the same structure, but not limited to that

### Example usage of the Api Controller

```php
class TestController extends ApiController
{
    public function actions()
    {
        return [
            'test1' => [
                'class' => ClosureAction::class,
                'closure' => function () {
                    Yii::debug('this is a closure action');
                    return ExecutionResult::success();
                }
            ],
            'test2' => [
                'class' => CollectorAction::class,
                'collectorClass' => TestCollector::class
            ],
            'test3' => [
                'class' => ApiModelAction::class,
                'modelClass' => TestModel::class
            ]
        ];
    }
}
```

`TestCollector` and `TestModel` extend the `collectors\AbstractDataCollector` and `models\AbstractApiModel` respectively

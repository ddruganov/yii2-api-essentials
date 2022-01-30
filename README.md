# yii2-api-essentials

Bunch of small components to make one's development life eaiser

## Installation

`composer require ddruganov/yii2-api-essentials`

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

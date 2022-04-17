# yii2-api-essentials

Bunch of small components to make one's yii2 api development life eaiser

## Installation

`composer require ddruganov/yii2-api-essentials`

## Description

This package contains useful classes (filters, behaviors, helpers, etc) for api development:

-   `behaviors\TimestampBehavior`: provides basic timestamping of an active record model with fields being 'created_at' and 'updated_at' (detects their existence automatically)
-   `collectors\AbstractDataCollector`: a convient way to collect data for an api call
-   `exceptions\ModelNotFoundException`: when a search for a model in database fails
-   `exceptions\NotImplementedException`: when you need to write an implementation for a method but... later :D
-   `forms\Form`: a container that performs validation of data and manipulates in a certain way; super useful for creating models without directly using an ActiveRecord; also used as a base for data collectors
-   `http\actions\ApiAction`: base class for all api actions that provides a way to get all incoming data as one array; returns an `ExecutionResult` and a status code appropriate for that execution result;
-   `http\actions\ClosureAction`: when the `ApiModelAction` is too overkill
-   `http\actions\FormAction`: provides a way to separate validation and saving of data to reduce class bloat; uses `Form`
-   `http\controllers\ApiController`: returns everything as json, measures every request timing and makes all api calls transactional
-   `http\filters\TimerFilter`: measures the time that an action takes and dumps into the debug log
-   `http\filters\TransactionFilter`: starts transaction before action, ends it after action; depends on `ExecutionResult` being successful
-   `testing\UnitTest`: base unit test class; provides a convenient way to assert `ExecutionResult` state and a customizable faker generator
-   `traits\Activity`: used in `ActiveQuery` to only get active models
-   `traits\Pagination`: used in `ActiveQuery` to set a page in a list query and to get a page count
-   `traits\Sorting`: used in `ActiveQuery` to sort models; deafult field is `created_at`
-   `traits\SoftDelete`: used in `ActiveRecord`, when a model is deleted the `deleted_at` field is filled with `date('Y-m-d H:i:s')`
-   `DateHelper`: bunch of useful methods for date manipulation
-   `ExecutionResult`: basically a statically typed version of an array with a specific structure to ensure that all methods working with data return the same structure, but not limited to that

## ApiController example

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
                'class' => FormAction::class,
                'formClass' => TestCollector::class
            ],
            'test3' => [
                'class' => FormAction::class,
                'formClass' => TestForm::class
            ]
        ];
    }
}
```

`TestCollector` and `TestForm` extend the `forms\Form`

## ActiveQuery traits example

```php
class SomeModelQuery extends ActiveQuery {
    use Activity, Pagination, Sorting;
}
```

## ActiveRecord-related components example

```php
class SomeActiveRecord extends ActiveRecord {

    use SoftDelete;

    public function behaviors() {
        return [TimestampBehavior::class];
    }
}
```

## Form example

```php
class SomeModelCreationForm extends Form {
    public ?string $name = null;
    public ?array $someRelatedModelIds = null;

    public function rules() {
        return [
            [['name','someRelatedModelIds'],'required'],
            [['name'],'string'],
            [['someRelatedModelIds'],'each', 'rule' => ['integer']]
        ];
    }

    protected function _run(): ExecutionResult {
        $model = new SomeModel();
        $model->setAttributes(['name' => $this->name]);
        if (!$model->save()) {
            return ExecutionResult::exception('Error saving model');
        }

        $result = $this->saveRelatedModelIds($model);
        if (!$result->isSuccessful()){
            return $result;
        }

        return ExecutionResult::success([
            'id' => $model->getId()
        ]);
    }

    private function saveRelatedModelIds(SomeModel $model) {
        ... bind related model ids here
    }
}
```

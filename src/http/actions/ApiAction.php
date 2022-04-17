<?php

namespace ddruganov\Yii2ApiEssentials\http\actions;

use ddruganov\Yii2ApiEssentials\ExecutionResult;
use Throwable;
use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

abstract class ApiAction extends Action
{
    private array $data = [];

    protected function beforeRun()
    {
        $this->mergeIncomingData();

        return parent::beforeRun();
    }

    final public function getData(string $key = null, mixed $default = null)
    {
        return $key ? ArrayHelper::getValue($this->data, $key, $default) : $this->data;
    }

    final public function runWithParams($params)
    {
        try {
            $result = parent::runWithParams($params);
            $statusCode = match (true) {
                (bool)$result->getException() => 500,
                (bool)$result->getErrors() => 400,
                default => 200
            };
            Yii::$app->getResponse()->setStatusCode($statusCode);
            return $result;
        } catch (Throwable $t) {
            Yii::error([$t->getMessage(), $t->getTraceAsString()]);
            Yii::$app->response->statusCode = 500;
            return ExecutionResult::exception('Ошибка сервера');
        }
    }

    public abstract function run(): ExecutionResult;

    private function mergeIncomingData()
    {
        $json = file_get_contents('php://input');
        $decoded = Json::decode($json) ?: [];

        $this->data = ArrayHelper::merge(Yii::$app->getRequest()->get(), $decoded);
    }
}

<?php

namespace ddruganov\Yii2ApiEssentials\common\http\actions;

use ddruganov\Yii2ApiEssentials\common\ExecutionResult;
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

    public function getData(string $key = null, mixed $default = null)
    {
        return $key ? ArrayHelper::getValue($this->data, $key, $default) : $this->data;
    }

    public function runWithParams($params)
    {
        try {
            return parent::runWithParams($params);
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

        $this->data = array_merge(Yii::$app->getRequest()->get(), $decoded);
    }
}

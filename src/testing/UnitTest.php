<?php

namespace ddruganov\Yii2ApiEssentials\testing;

use Codeception\Test\Unit;
use ddruganov\Yii2ApiEssentials\ExecutionResult;
use ddruganov\Yii2ApiEssentials\testing\traits\UseFaker;
use Yii;
use yii\db\Transaction;
use yii\helpers\Console;
use yii\helpers\VarDumper;

abstract class UnitTest extends Unit
{
    use UseFaker;

    private Transaction $transaction;

    protected function _setUp()
    {
        $this->transaction = Yii::$app->getDb()->beginTransaction();
        parent::_setUp();
    }

    protected function _tearDown()
    {
        parent::_tearDown();
        $this->transaction->rollBack();
    }

    protected function log(mixed $data)
    {
        Console::output(VarDumper::dumpAsString($data));
    }

    protected function assertExecutionResultSuccessful(ExecutionResult $result)
    {
        $this->assertTrue($result->isSuccessful());
        $this->assertNull($result->getException());
        $this->assertEmpty($result->getErrors());
    }

    protected function assertExecutionResultException(ExecutionResult $result)
    {
        $this->assertFalse($result->isSuccessful());
        $this->assertNotNull($result->getException());
        $this->assertEmpty($result->getErrors());
        $this->assertNull($result->getData());
    }

    protected function assertExecutionResultErrors(ExecutionResult $result, array $errorKeys = [], array $noErrorKeys = [])
    {
        $this->assertFalse($result->isSuccessful());
        $this->assertNull($result->getException());
        $this->assertNotEmpty($result->getErrors());
        $this->assertNull($result->getData());

        foreach ($errorKeys as $errorKey) {
            $this->assertNotNull($result->getError($errorKey));
        }

        foreach ($noErrorKeys as $noErrorKey) {
            $this->assertNull($result->getError($noErrorKey));
        }
    }
}

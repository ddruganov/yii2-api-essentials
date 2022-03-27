<?php

namespace tests\unit\tests;

use ddruganov\Yii2ApiEssentials\forms\Form;
use ddruganov\Yii2ApiEssentials\ExecutionResult;
use ddruganov\Yii2ApiEssentials\testing\UnitTest;

final class FormTest extends UnitTest
{
    public function testWithoutRules()
    {
        $form = $this->createFormWithoutRules();
        $result = $form->run();
        $this->assertExecutionResultSuccessful($result);
    }

    public function testWithRulesInvalid()
    {
        $form = $this->createFormWithRules();
        $result = $form->run();
        $this->assertExecutionResultErrors(
            result: $result,
            errorKeys: ['checkMe']
        );
    }

    public function testWithRulesValid()
    {
        $form = $this->createFormWithRules();
        $form->setAttributes([
            'checkMe' => $this->getFaker()->text()
        ]);
        $result = $form->run();
        $this->assertExecutionResultSuccessful($result);
    }

    private function createFormWithoutRules()
    {
        return new class extends Form
        {
            protected function _run(): ExecutionResult
            {
                return ExecutionResult::success();
            }
        };
    }

    private function createFormWithRules()
    {
        return new class extends Form
        {
            public ?string $checkMe = null;

            public function rules()
            {
                return [
                    [['checkMe'], 'required']
                ];
            }

            protected function _run(): ExecutionResult
            {
                return ExecutionResult::success();
            }
        };
    }
}

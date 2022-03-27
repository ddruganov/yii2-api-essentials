<?php

namespace tests\unit\tests;

use ddruganov\Yii2ApiEssentials\forms\AbstractForm;
use ddruganov\Yii2ApiEssentials\ExecutionResult;
use ddruganov\Yii2ApiEssentials\testing\traits\UseFaker;
use ddruganov\Yii2ApiEssentials\testing\UnitTest;

final class FormTest extends UnitTest
{
    public function testWithoutRules()
    {
        $form = $this->createFormWithoutRules();
        $result = $form->run();
        $this->assertExecutionResultSuccessful($result);
        $this->assertNotEmpty($result->getData());
        $this->assertIsArray($result->getData());
        $this->assertIsString($result->getData('text'));
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
            'checkMe' => $this->faker()->text()
        ]);
        $result = $form->run();
        $this->assertExecutionResultSuccessful($result);
        $this->assertNotEmpty($result->getData());
        $this->assertIsArray($result->getData());
        $this->assertIsString($result->getData('text'));
    }

    private function createFormWithoutRules()
    {
        return new class extends AbstractForm
        {
            use UseFaker;
            protected function _run(): ExecutionResult
            {
                return ExecutionResult::success(['text' => $this->faker()->text()]);
            }
        };
    }

    private function createFormWithRules()
    {
        return new class extends AbstractForm
        {
            use UseFaker;

            public ?string $checkMe = null;

            public function rules()
            {
                return [
                    [['checkMe'], 'required']
                ];
            }

            protected function _run(): ExecutionResult
            {
                return ExecutionResult::success(['text' => $this->faker()->text()]);
            }
        };
    }
}

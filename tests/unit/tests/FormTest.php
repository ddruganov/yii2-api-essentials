<?php

namespace tests\unit\tests;

use ddruganov\Yii2ApiEssentials\forms\AbstractForm;
use ddruganov\Yii2ApiEssentials\ExecutionResult;
use tests\unit\BaseUnitTest;
use tests\unit\UseFaker;

class FormTest extends BaseUnitTest
{
    public function testWithoutRules()
    {
        $form = $this->createFormWithoutRules();
        $result = $form->run();
        $this->assertTrue($result->isSuccessful());
        $this->assertNull($result->getException());
        $this->assertEmpty($result->getErrors());
        $this->assertNotEmpty($result->getData());
    }

    private function createFormWithoutRules()
    {
        return new class extends AbstractForm
        {
            use UseFaker;
            protected function _run(): ExecutionResult
            {
                return ExecutionResult::success([$this->faker()->text()]);
            }
        };
    }

    public function testWithRulesInvalid()
    {
        $form = $this->createFormWithRules();
        $result =  $form->run();
        $this->assertFalse($result->isSuccessful());
        $this->assertNull($result->getException());
        $this->assertNotEmpty($result->getErrors());
        $this->assertNotNull($result->getError('checkMe'));
        $this->assertNull($result->getData());
    }

    public function testWithRulesValid()
    {
        $form = $this->createFormWithRules();
        $form->setAttributes([
            'checkMe' => $this->faker()->text()
        ]);
        $result =  $form->run();
        $this->assertTrue($result->isSuccessful());
        $this->assertNull($result->getException());
        $this->assertEmpty($result->getErrors());
        $this->assertNotEmpty($result->getData());
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
                return ExecutionResult::success([$this->faker()->text()]);
            }
        };
    }
}

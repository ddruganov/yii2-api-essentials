<?php

namespace tests\unit\tests;

use ddruganov\Yii2ApiEssentials\ExecutionResult;
use ddruganov\Yii2ApiEssentials\testing\UnitTest;

class ExecutionResultTest extends UnitTest
{
    public function testConstructorWithSuccess()
    {
        $result = new ExecutionResult(true);
        $this->assertTrue($result->isSuccessful());
        $this->assertNull($result->getException());
        $this->assertNull($result->getData());
        $this->assertEmpty($result->getErrors());
    }

    public function testConstructorWithoutSuccess()
    {
        $result = new ExecutionResult(false);
        $this->assertFalse($result->isSuccessful());
        $this->assertNull($result->getException());
        $this->assertNull($result->getData());
        $this->assertEmpty($result->getErrors());
    }

    public function testStaticSuccess()
    {
        $dataSets = [
            null,
            $this->getFaker()->numberBetween(),
            $this->getFaker()->text(),
            [],
            [$this->getFaker()->numberBetween()],
            [$this->getFaker()->asciify() => $this->getFaker()->numberBetween()],
            [
                $this->getFaker()->asciify() => []
            ]
        ];

        foreach ($dataSets as $dataSet) {
            $result = ExecutionResult::success($dataSet);
            $this->assertTrue($result->isSuccessful());
            $this->assertNull($result->getException());
            $this->assertEmpty($result->getErrors());

            $this->assertEquals(gettype($result->getData()), gettype($dataSet));
        }
    }

    public function testStaticException()
    {
        $message = $this->getFaker()->text();
        $result = ExecutionResult::exception($message);
        $this->assertFalse($result->isSuccessful());
        $this->assertNotNull($result->getException());
        $this->assertEquals($result->getException(), $message);
        $this->assertNull($result->getData());
        $this->assertEmpty($result->getErrors());
    }

    public function testStaticErrors()
    {
        $errors = [
            'test' => $this->getFaker()->asciify(),
            'test2' => $this->getFaker()->numberBetween(),
            'test3' => []
        ];

        $result = ExecutionResult::failure($errors);
        $this->assertFalse($result->isSuccessful());
        $this->assertNull($result->getException());
        $this->assertNull($result->getData());
        $this->assertNotEmpty($result->getErrors());

        $this->assertNotNull($result->getError('test'));
        $this->assertIsString($result->getError('test'));

        $this->assertNotNull($result->getError('test2'));
        $this->assertIsNumeric($result->getError('test2'));

        $this->assertNotNull($result->getError('test3'));
        $this->assertIsArray($result->getError('test3'));

        $this->assertNull($result->getError('test4'));
        $this->assertIsString($result->getError('test4', 'placeholder'));
        $this->assertIsNumeric($result->getError('test4', 123));
        $this->assertIsArray($result->getError('test4', []));
    }

    public function testToArray()
    {
        $result = ExecutionResult::success();
        $asArray = $result->toArray();

        $this->assertEquals($result->isSuccessful(), $asArray['success']);
        $this->assertEquals($result->getException(), $asArray['exception']);
        $this->assertEquals($result->getData(), $asArray['data']);
        $this->assertEquals($result->getErrors(), $asArray['errors']);
    }

    public function testFromArray()
    {
        $data = [
            'success' => false,
            'exception' => $this->getFaker()->text(),
            'data' => [],
            'errors' => []
        ];

        $result = ExecutionResult::fromArray($data);

        $this->assertEquals($result->isSuccessful(), $data['success']);
        $this->assertEquals($result->getException(), $data['exception']);
        $this->assertEquals($result->getData(), $data['data']);
        $this->assertEquals($result->getErrors(), $data['errors']);
    }
}

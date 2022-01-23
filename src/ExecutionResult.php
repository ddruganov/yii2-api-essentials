<?php

namespace src;

use yii\base\Arrayable;
use yii\helpers\ArrayHelper;

class ExecutionResult implements Arrayable
{
    private bool $success;
    private ?string $exception;
    private mixed $data;
    private array $errors;

    public function __construct(bool $success, ?string $exception = null, mixed $data = null, array $errors = [])
    {
        $this->success = $success;
        $this->exception = $exception;
        $this->data = $data;
        $this->errors = $errors;
    }

    public function isSuccessful()
    {
        return $this->success;
    }

    public function getException()
    {
        return $this->exception;
    }

    public function getData(?string $key = null, mixed $default = null)
    {
        return $key ? ArrayHelper::getValue($this->data, $key, $default) : $this->data;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function fields()
    {
    }

    public function extraFields()
    {
    }

    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        return [
            'success' => $this->success,
            'exception' => $this->exception,
            'errors' => $this->errors,
            'data' => $this->data
        ];
    }

    public static function success(mixed $data = null)
    {
        return new self(true, null, $data, []);
    }

    public static function failure(array $errors)
    {
        return new self(false, null, null, $errors);
    }

    public static function exception(string $exception)
    {
        return new self(false, $exception, [], []);
    }

    public static function fromArray(array $data)
    {
        return new self($data['success'] ?? false, $data['exception'] ?? null, $data['data'] ?? null, $data['errors'] ?? []);
    }
}

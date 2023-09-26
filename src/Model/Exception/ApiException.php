<?php
namespace App\Model\Exception;

use RuntimeException;
use Throwable;

class ApiException extends RuntimeException
{
    protected array $errors = [];

    public function __construct(array $errors, $message = "", $code = 0, Throwable $previous = null)
    {
        if(empty($errors)){
            $this->errors['error'] = $message;
        } else {
            $this->errors = $errors;
        }

        parent::__construct($message, $code, $previous);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
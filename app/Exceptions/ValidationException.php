<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class ValidationException extends Exception
{
    protected $errors;

    public function __construct($errors)
    {
        $this->errors = $errors;
    }

    public function render($request)
    {
        return response()->json(['errors' => [
            [
                // 'code' => 100,
                'detail' => $this->errors
            ]
        ]], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}

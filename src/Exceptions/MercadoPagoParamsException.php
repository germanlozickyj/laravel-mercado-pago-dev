<?php
 
namespace Germanlozickyj\LaravelMercadoPago\Exceptions;
 
use Exception;
use Germanlozickyj\LaravelMercadoPago\Enums\ParamsErrorsEnum;

class MercadoPagoParamsException extends Exception
{
    public $from;

    public array $errors;

    public function __construct(
        ParamsErrorsEnum $from, 
        array $errors
    )
    {
        $this->from = $from;
        $this->errors = $errors;
    }

    public function report() 
    {
        $this->message = $this->from->getMessage($this->errors);
    }
}
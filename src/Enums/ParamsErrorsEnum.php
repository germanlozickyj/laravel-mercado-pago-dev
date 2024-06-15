<?php

namespace Germanlozickyj\LaravelMercadoPago\Enums;

enum ParamsErrorsEnum: string
{
    case PLAN = 'plan';

    public function getMessage(array $errors)
    {
        return match ($this) {
            ParamsErrorsEnum::PLAN => 'Error Mercado Pago Plan. '.$this->createMessage($this, $errors)
        };
    }

    protected function createMessage(
        ParamsErrorsEnum $from, 
        array $errors
    )
    {   
        foreach($errors as $value) {
            return $this->getFirstError($value[0]);
        }
    }

    protected function getFirstError(string $dto_message)
    {
        return match($dto_message) {
            'The auto recurring field is required.' => 'Metodos withFrequencyType(), withCurrencyId(), withFrequency() son requeridos',
            'The auto recurring.frequency field is required.' => 'Metodo withFrequency() es requerido',
            'The auto recurring.frequency_type field is required.' => 'Metodo withFrequencyType() es requerido',
            'The reason field is required.' => 'Metodo withReason() es requerido',
            'The auto recurring.currency id field is required.' => 'Metodo withCurrencyId() es requerido',
            'The selected auto recurring.currency id is invalid.' => 'withCurrencyId() valor no valido. Valores validos: ' . CurrencyEnum::getStringCases(),
            
            default => $dto_message
        };
    }
}
<?php

namespace Germanlozickyj\LaravelMercadoPago\Enums;

enum CurrencyEnum: string
{
    case ARS = 'ARS';
    case BRL = 'BRL';
    case CLP = 'CLP';
    case MXN = 'MXN';
    case COP = 'COP';
    case PEN = 'PEN';
    case UYU = 'UYU';

    public static function getStringCases() 
    {
        $result = '';
        $cases = self::cases();
        $last = array_pop($cases);

        foreach ($cases as $case) {
            $result.= $case->value.', ';
        }
        $result.= $last->value.'.';

        return $result;
    }
}
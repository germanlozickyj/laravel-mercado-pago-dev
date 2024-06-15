<?php

namespace Germanlozickyj\LaravelMercadoPago\Data\Plans;

use Germanlozickyj\LaravelMercadoPago\Enums\CurrencyEnum;
use Germanlozickyj\LaravelMercadoPago\Enums\FrequencyTypeEnum;
use Spatie\LaravelData\Attributes\Validation\Between;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class AutoRecurringDto extends Data
{
    #[Required]
    public int $frequency;
    #[Required, Enum(FrequencyTypeEnum::class)]
    public FrequencyTypeEnum $frequency_type;
    public ?int $repetitions;
    #[Between(1, 28)]
    public ?int $billing_day;
    public ?bool $billing_day_proportional;
    public ?FreeTrialDto $free_trial;
    public $transaction_amount;
    #[Required, Enum(CurrencyEnum::class)]
    public string $currency_id;
}
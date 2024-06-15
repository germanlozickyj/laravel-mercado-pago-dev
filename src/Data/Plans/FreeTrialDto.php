<?php

namespace Germanlozickyj\LaravelMercadoPago\Data\Plans;

use Germanlozickyj\LaravelMercadoPago\Enums\FrequencyTypeEnum;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;

class FreeTrialDto extends Data
{
    #[Required]
    public ?int $frequency;
    #[Required, Enum(FrequencyTypeEnum::class)]
    public ?FrequencyTypeEnum $frequency_type;
}
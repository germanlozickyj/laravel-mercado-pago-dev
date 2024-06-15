<?php

namespace Germanlozickyj\LaravelMercadoPago\Data\Plans;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Url;
use Spatie\LaravelData\Data;

class PlanDto extends Data
{
    #[Required]
    public AutoRecurringDto $auto_recurring;
    #[Required, Url]
    public string $back_url;
    public ?PaymentMethodsAllowedDto $payment_methods_allowed;
    #[Required]
    public string $reason;
}
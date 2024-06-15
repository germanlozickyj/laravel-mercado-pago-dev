<?php 

namespace Germanlozickyj\LaravelMercadoPago\Models;

use Germanlozickyj\LaravelMercadoPago\Data\Plans\AutoRecurringDto;
use Germanlozickyj\LaravelMercadoPago\Data\Plans\PaymentMethodsAllowedDto;
use Germanlozickyj\LaravelMercadoPago\Enums\PlanStatusEnum;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $guarded = [];

    protected $casts = [
        'auto_recurring' => AutoRecurringDto::class,
        'payment_methods_allowed' => PaymentMethodsAllowedDto::class,
        'status' => PlanStatusEnum::class
    ];
}
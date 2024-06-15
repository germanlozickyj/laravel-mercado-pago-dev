<?php

namespace Germanlozickyj\LaravelMercadoPago\Enums;

enum PlanStatusEnum: string
{
    case ACTIVE = 'active';
    case CANCELLED = 'cancelled';
}
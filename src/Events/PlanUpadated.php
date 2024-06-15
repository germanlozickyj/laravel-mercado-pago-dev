<?php

namespace Germanlozickyj\LaravelMercadoPago\Events;

use Germanlozickyj\LaravelMercadoPago\Data\Plans\PlanDto;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlanUpdated
{
    use Dispatchable, 
        InteractsWithSockets, 
        SerializesModels;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}

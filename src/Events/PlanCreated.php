<?php

namespace Germanlozickyj\LaravelMercadoPago\Events;

use Germanlozickyj\LaravelMercadoPago\Data\Plans\PlanDto;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlanCreated
{
    use Dispatchable, 
        InteractsWithSockets, 
        SerializesModels;

    public PlanDto $data;

    public function __construct(PlanDto $data)
    {
        $this->data = $data;
    }
}

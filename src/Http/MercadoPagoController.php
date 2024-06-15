<?php

namespace Germanlozickyj\LaravelMercadoPago\Http;

use Germanlozickyj\LaravelMercadoPago\Data\Subscription\FormDataPayment;
use Germanlozickyj\LaravelMercadoPago\LaravelMercadoPago;
use Germanlozickyj\LaravelMercadoPago\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MercadoPagoController extends Controller
{
    public function subscribe(Request $request)
    {
        $plan = Plan::first();
        
        $response = LaravelMercadoPago::api('post', 'preapproval', [
            "auto_recurring" => $plan->auto_recurring->toArray(),
            "back_url" => $plan->back_url,
            "card_token_id" => $request->get('card_token_id'),
            "external_reference" => "YG-1234",
            "payer_email" => $request->get('email'),
            "preapproval_plan_id" => $plan->mercado_pago_plan_id,
            "reason" => $plan->reason,
            "status" => "authorized"
        ]);

        dd($response);
    }
}
<?php

namespace Germanlozickyj\LaravelMercadoPago;

use Germanlozickyj\LaravelMercadoPago\Data\Plans\AutoRecurringDto;
use Germanlozickyj\LaravelMercadoPago\Data\Plans\PaymentMethodsAllowedDto;
use Germanlozickyj\LaravelMercadoPago\Data\Plans\PlanDto;
use Germanlozickyj\LaravelMercadoPago\Enums\ParamsErrorsEnum;
use Germanlozickyj\LaravelMercadoPago\Events\PlanCreated;
use Germanlozickyj\LaravelMercadoPago\Events\PlanUpdated;
use Germanlozickyj\LaravelMercadoPago\Exceptions\MercadoPagoApiException;
use Germanlozickyj\LaravelMercadoPago\Exceptions\MercadoPagoParamsException;
use Germanlozickyj\LaravelMercadoPago\Models\Plan;
use Illuminate\Http\Client\Response;
use Illuminate\Validation\ValidationException;

class MercadoPagoPlan extends LaravelMercadoPago {

    protected array $collection = [];

    private bool $update_mode = false;

    private int $plan_id;

    private static int $plan_id_static;


    public static function make() : self 
    {
        return new static();
    }

    public function create() : bool
    {
        try {
            $dtoData = PlanDto::validateAndCreate(
                $this->collection
            );

        } catch(ValidationException $errors) {
            throw new MercadoPagoParamsException(
                ParamsErrorsEnum::PLAN,
                $errors->errors()
            );
        }

        MercadoPagoPlan::api(
            'post',
            '/preapproval_plan',
            $dtoData->toArray()
        );

        PlanCreated::dispatch($dtoData);

        return true;
    }


    public static function handleResponse(Response $response)
    {
        $data = $response->json();

        if($response->transferStats->getRequest()->getMethod() == 'PUT') {
            Plan::whereId(self::$plan_id_static)
                ->first()
                ->update([
                    'application_id' => $data['application_id'],
                    'mercado_pago_plan_id' => $data['id'],
                    'back_url' => $data['back_url'],
                    'reason' => $data['reason'],
                    'status' => $data['status'],
                    'url' => $data['init_point'],
                    'auto_recurring' => AutoRecurringDto::from($data['auto_recurring']),
                    'payment_methods_allowed' => PaymentMethodsAllowedDto::from($data['payment_methods_allowed'])
                ]);
        } 

        if($response->transferStats->getRequest()->getMethod() == 'POST') {
            Plan::create([
                'application_id' => $data['application_id'],
                'mercado_pago_plan_id' => $data['id'],
                'back_url' => $data['back_url'],
                'reason' => $data['reason'],
                'status' => $data['status'],
                'url' => $data['init_point'],
                'auto_recurring' => AutoRecurringDto::from($data['auto_recurring']),
                'payment_methods_allowed' => PaymentMethodsAllowedDto::from($data['payment_methods_allowed'])
            ]);
        }
    }

    public function withFreeTrial(
        int $frequency,
        string $frequency_type
    ) : self
    {
        $this->collection['auto_recurring']['free_trial'] = [
            'frequency' => $frequency,
            'frequency_type' => $frequency_type
        ];
        
        return $this;
    }

    public function withBackUrl(string $url) : self
    {
        $this->collection['back_url'] = $url;

        return $this;
    }

    public function withReason(string $reason) : self
    {
        $this->collection['reason'] = $reason;

        return $this;    
    }

    public function withFrequencyType(string $frequency_type) : self
    {
        $this->collection['auto_recurring']['frequency_type'] = $frequency_type;

        return $this;
    }

    public function withFrequency(int $frequency) : self
    {
        $this->collection['auto_recurring']['frequency'] = $frequency;

        return $this;
    }

    public function withCurrencyId(string $currency) : self
    {
        $this->collection['auto_recurring']['currency_id'] = $currency;
        
        return $this;
    }

    public function withRepetitions(int $repetitions) : self
    {
        $this->collection['auto_recurring']['repetitions'] = $repetitions;
        
        return $this;
    }

    public function withBillingDay(int $billing_day) : self
    {
        $this->collection['auto_recurring']['billing_day'] = $billing_day;

        return $this;
    }

    public function withBillingDayProportional(bool $billing_day_proportional) : self
    {
        $this->collection['auto_recurring']['billing_day_proportional'] = $billing_day_proportional;

        return $this;
    }

    public function withTransactionAmount(int $transaction_amount) : self
    {
        $this->collection['auto_recurring']['transaction_amount'] = $transaction_amount;

        return $this;
    }

    public static function updateById(int $id) : self
    {
        if(! Plan::whereId($id)->exists()) {
            throw new MercadoPagoApiException(
                'No se encontro plan con ese id para actualizar'
            );
        }

        $static = new static();
        $static->update_mode = true;
        $static->plan_id = $id;
        $static::$plan_id_static = $id;

        return $static;
    }

    public function update() 
    {
        if(! $this->update_mode) {
            throw new MercadoPagoApiException(
                'Tienes que inicializar la actualizacion llamando primero al metodo updateById($id)'
            );
        }

        $plan = Plan::whereId($this->plan_id)
                    ->first()
                    ->toArray();
        try {
            $update_data = PlanDto::validateAndCreate(
                            $this->collection
                        );
        } catch(ValidationException $errors) {
            throw new MercadoPagoParamsException(
                ParamsErrorsEnum::PLAN,
                $errors->errors()
            );
        }

        $original = [
            'auto_recurring' => [
                'frequency' => $plan['auto_recurring']['frequency'],
                'frequency_type' => $plan['auto_recurring']['frequency_type'],
                'repetitions' => $plan['auto_recurring']['repetitions'],
                'billing_day' => $plan['auto_recurring']['billing_day'],
                'free_trial' => $plan['auto_recurring']['free_trial'],
                'transaction_amount' => $plan['auto_recurring']['transaction_amount'],
                'currency_id' => $plan['auto_recurring']['currency_id']
            ],
            'back_url' => $plan['back_url'],
            'reason' => $plan['reason'],
            "payment_methods_allowed" => null
        ];

        $this->collection = array_merge(
                                $original, 
                                $update_data->toArray()
                            );
        
        MercadoPagoPlan::api(
            'put',
            "preapproval_plan/{$plan['mercado_pago_plan_id']}",
            $this->collection
        );

        PlanUpdated::dispatch($this->collection);

        return true;
    }
}
<?php

namespace Germanlozickyj\LaravelMercadoPago\Data\Subscription;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class FormDataPayment extends Data
{
    #[Required]
    public string $token;
    #[Required]
    public string $issuer_id;
    #[Required]
    public string $payment_method_id;
    #[Required]
    public string $card_token_id;
    #[Required, Email]
    public string $email;
    #[Required]
    public string $identification_type;
    #[Required]
    public string $document_number;
    #[Required]
    public string $cardHolderName;
    #[Required]
    public string $installments;
}
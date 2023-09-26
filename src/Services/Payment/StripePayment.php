<?php

namespace App\Services\Payment;

use App\Model\Exception\ApiException;
use App\Model\Interfaces\PaymentProcessorInterface;
use App\Services\PaymentProcessor\StripePaymentProcessor;
use Exception;

class StripePayment implements PaymentProcessorInterface
{
    const STRIPE_PAYMENT_PROCESSOR = 'stripe';

    private StripePaymentProcessor $stripePaymentProcessor;

    public function __construct(StripePaymentProcessor $stripePaymentProcessor)
    {
        $this->stripePaymentProcessor = $stripePaymentProcessor;
    }

    /**
     * @throws Exception
     */
    public function pay(int $price): void
    {
         if(!$this->stripePaymentProcessor->processPayment($price)) {
             throw new ApiException([self::STRIPE_PAYMENT_PROCESSOR => 'Too small price']);
         };
    }
}
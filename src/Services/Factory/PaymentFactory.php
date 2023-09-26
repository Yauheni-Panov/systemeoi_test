<?php

namespace App\Services\Factory;

use App\Model\Exception\ApiException;
use App\Model\Interfaces\PaymentProcessorInterface;
use App\Services\Payment\PaypalPayment;
use App\Services\Payment\StripePayment;
use App\Services\PaymentProcessor\PaypalPaymentProcessor;
use App\Services\PaymentProcessor\StripePaymentProcessor;

class PaymentFactory
{
    public static function getPaymentMethod(string $paymentProcess): PaymentProcessorInterface
    {
        switch ($paymentProcess) {
            case StripePayment::STRIPE_PAYMENT_PROCESSOR:
                $stripePaymentProcessor =  new StripePaymentProcessor();
                return new StripePayment($stripePaymentProcessor);
            case PaypalPayment::PAYPAL_PAYMENT_PROCESSOR:
                $paypalPaymentProcessor = new PaypalPaymentProcessor();
                return new PaypalPayment($paypalPaymentProcessor);
            default:
                throw new ApiException(['paymentMethod' => 'Undefined payment method']);
        }
    }
}
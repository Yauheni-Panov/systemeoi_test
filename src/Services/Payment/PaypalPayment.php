<?php

namespace App\Services\Payment;

use App\Model\Exception\ApiException;
use App\Model\Interfaces\PaymentProcessorInterface;
use App\Services\PaymentProcessor\PaypalPaymentProcessor;
use Exception;

class PaypalPayment implements PaymentProcessorInterface
{
    const PAYPAL_PAYMENT_PROCESSOR = 'paypal';

    private PaypalPaymentProcessor $paypalPaymentProcessor;

    public function __construct(PaypalPaymentProcessor $paypalPaymentProcessor)
    {
        $this->paypalPaymentProcessor = $paypalPaymentProcessor;
    }

    public function pay(int $price): void
    {
        try {
            $this->paypalPaymentProcessor->pay($price);
        } catch (Exception $e) {
            throw new ApiException([self::PAYPAL_PAYMENT_PROCESSOR => $e->getMessage()]);
        }
    }
}
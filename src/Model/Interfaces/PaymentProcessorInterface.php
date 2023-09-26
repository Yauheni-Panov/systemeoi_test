<?php
namespace App\Model\Interfaces;

interface PaymentProcessorInterface
{
    public function pay(int $price): void;
}
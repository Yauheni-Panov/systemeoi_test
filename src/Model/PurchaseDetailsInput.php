<?php

namespace App\Model;

use App\Entity\Coupon;
use App\Entity\Product;
use App\Entity\Tax;
use App\Model\Interfaces\PaymentProcessorInterface;

class PurchaseDetailsInput
{
    const PRODUCT = "product";
    const TAX_NUMBER = "taxNumber";
    const COUPON_CODE = "couponCode";
    const PAYMENT_PROCESSOR = "paymentProcessor";

    const API_INPUT = [
        self::PRODUCT,
        self::TAX_NUMBER,
        self::COUPON_CODE,
        self::PAYMENT_PROCESSOR
    ];

    protected Product $product;

    protected Tax $taxNumber;

    protected ?Coupon $coupon;

    protected ?PaymentProcessorInterface $paymentProcessor;

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getTaxNumber(): Tax
    {
        return $this->taxNumber;
    }

    public function setTaxNumber(Tax $taxNumber): self
    {
        $this->taxNumber = $taxNumber;

        return $this;
    }

    public function getCoupon(): ?Coupon
    {
        return $this->coupon;
    }

    public function setCouponCode(?Coupon $coupon): self
    {
        $this->coupon = $coupon;

        return $this;
    }

    public function getPaymentProcessor(): ?PaymentProcessorInterface
    {
        return $this->paymentProcessor;
    }

    public function setPaymentProcessor(?PaymentProcessorInterface $paymentProcessor): self
    {
        $this->paymentProcessor = $paymentProcessor;

        return $this;
    }
}
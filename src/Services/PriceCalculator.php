<?php

namespace App\Services;

use App\Model\PurchaseDetailsInput;

class PriceCalculator
{
    public function calculatePrice(PurchaseDetailsInput $purchaseDetailsInput): float|int
    {
        $product = $purchaseDetailsInput->getProduct();
        $tax = $purchaseDetailsInput->getTaxNumber();
        $couponCode = $purchaseDetailsInput->getCoupon();

        $price = $this->addPercent($purchaseDetailsInput->getProduct()->getPrice(), $tax->getQuantity());

        if($couponCode){
            if($couponCode->isFixedAmountDiscountType() && $product->getPrice() - $couponCode->getQuantity() > 0) {

                $priceAfterCoupon = $this->addPercent($product->getPrice() - $couponCode->getQuantity(), $tax->getQuantity());
            }elseif($couponCode->isPercentageDiscountType()) {

                $priceAfterCoupon = $this->addPercent($this->reducePercent($product->getPrice(), $couponCode->getQuantity()),  $tax->getQuantity());
            }
        }

        return $priceAfterCoupon ?? $price;
    }

    public function calculatePriceInCents(PurchaseDetailsInput $purchaseDetailsInput): float|int
    {
        return $this->calculatePrice($purchaseDetailsInput) * 100;
    }

    public function addPercent($price, $percent): float|int
    {
        return $price + ($price * $percent / 100);
    }

    public function reducePercent($price, $percent): float|int
    {
        return $price - ($price * $percent / 100);
    }
}
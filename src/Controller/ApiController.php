<?php

namespace App\Controller;

use App\Model\PurchaseDetailsInput;
use App\Services\PriceCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\ValueResolver;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('calculate-price',name: 'calculate-price', methods: 'POST')]
    public function calculatePrice(#[ValueResolver('purchase_details_input')] PurchaseDetailsInput $purchaseDetailsInput, PriceCalculator $priceCalculator): JsonResponse
    {
        $price = $priceCalculator->calculatePriceInCents($purchaseDetailsInput);

        return $this->json(
            $price,
            Response::HTTP_OK
        );
    }

    #[Route('purchase', name: 'purchase', methods: 'POST')]
    public function purchase(#[ValueResolver('purchase_details_input')] PurchaseDetailsInput $purchaseDetailsInput, PriceCalculator $priceCalculator): JsonResponse
    {
        $price = $priceCalculator->calculatePriceInCents($purchaseDetailsInput);
        $purchaseDetailsInput->getPaymentProcessor()->pay($price);

        return $this->json('Payment success', Response::HTTP_OK);
    }
}
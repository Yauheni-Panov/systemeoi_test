<?php
namespace App\Serializer\Denormalizer;

use App\Entity\Coupon;
use App\Entity\Product;
use App\Entity\Tax;
use App\Model\PurchaseDetailsInput;
use App\Services\Factory\PaymentFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Exception\PartialDenormalizationException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class PurchaseDetailsDenormalizer implements DenormalizerInterface
{
    protected array $classes;
    protected EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function denormalize($data, $class, $format = null, array $context = [])
    {
        $productDto = new $class;
        $entityManager = $this->entityManager;
        $denormalizationErrors = [];


        if (!$product = $entityManager->getRepository(Product::class)->findOneBy(['id' => $data[PurchaseDetailsInput::PRODUCT]])) {

            $denormalizationErrors[] = NotNormalizableValueException::createForUnexpectedDataType(
                sprintf("Data expected to be '%s', '%s' given.", Product::class, 'null'),
                '',
                expectedTypes: [
                    Product::class
                ],
                path: PurchaseDetailsInput::PRODUCT,
            );
        }

        $countryCode = substr($data[PurchaseDetailsInput::TAX_NUMBER], 0, 2);
        $country = Countries::getName($countryCode);

        if (!$tax = $entityManager->getRepository(Tax::class)->findOneBy(['country' => $country])) {

            $denormalizationErrors[] = NotNormalizableValueException::createForUnexpectedDataType(
                sprintf("Data expected to be '%s', '%s' given.", Tax::class, $tax),
                '',
                expectedTypes: [
                    Tax::class
                ],
                path: PurchaseDetailsInput::TAX_NUMBER,
            );
        }

        if (isset($data[PurchaseDetailsInput::COUPON_CODE])) {
            $couponCode = $this->entityManager->getRepository(Coupon::class)->findOneBy(['code' => $data[PurchaseDetailsInput::COUPON_CODE]]);

            if(!$couponCode) {
                $denormalizationErrors[] = NotNormalizableValueException::createForUnexpectedDataType(
                    sprintf("Data expected to be '%s', '%s' given.", Coupon::class, 'null'),
                    '',
                    expectedTypes: [
                        Coupon::class
                    ],
                    path: PurchaseDetailsInput::COUPON_CODE,
                );
            }
        }

        if (!empty($denormalizationErrors)){
            throw new PartialDenormalizationException('', $denormalizationErrors);
        }

        $productDto
            ->setProduct($product)
            ->setTaxNumber($tax)
            ->setCouponCode($couponCode ?? null)
            ->setPaymentProcessor(isset($data[PurchaseDetailsInput::PAYMENT_PROCESSOR]) ? PaymentFactory::getPaymentMethod($data[PurchaseDetailsInput::PAYMENT_PROCESSOR]) : null);

        return $productDto;
    }

    public function supportsDenormalization($data, $type, $format = null): bool
    {
       return $type === PurchaseDetailsInput::class;
    }
}
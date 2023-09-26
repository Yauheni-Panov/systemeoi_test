<?php
namespace App\Validator\Constraints;

use App\Model\PurchaseDetailsInput;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PaymentDataValidator extends ConstraintValidator
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof PaymentData) {
            throw new UnexpectedTypeException($constraint, PaymentData::class);
        }

        foreach($value as $input => $v) {
            if (!in_array($input, PurchaseDetailsInput::API_INPUT)) {
                $this->addViolation($constraint->extraFieldsMessage, $input);

                return;
            }
        }

        if (!isset($value['product'])) {
            $this->addViolation($constraint->missingFieldsMessage, PurchaseDetailsInput::PRODUCT);

            return;
        }

        if (null === $value['product'] || '' === $value['product']) {
             $this->addViolation($constraint->notBlankMessage, PurchaseDetailsInput::PRODUCT);

            return;
        }

        if (!isset($value['taxNumber'])) {
            $this->addViolation($constraint->missingFieldsMessage, PurchaseDetailsInput::TAX_NUMBER);

            return;
        }

        if (null === $value['taxNumber'] || '' === $value['taxNumber']) {
            $this->addViolation($constraint->notBlankMessage, PurchaseDetailsInput::TAX_NUMBER);

            return;
        }

        $taxNumberValidationResult = $this->validator->validate($value['taxNumber'], new TaxNumber());

        if ($taxNumberValidationResult->count() > 0){
            $this->addViolation($constraint->taxNumberMessage, PurchaseDetailsInput::TAX_NUMBER);

            return;
        }

        if (isset($value['couponCode'])) {
            if (null === $value['couponCode'] || '' === $value['couponCode']) {
                $this->addViolation($constraint->notBlankMessage, PurchaseDetailsInput::COUPON_CODE);

                return;
            }
        }

        if (PaymentData::GROUP_PURCHASE === $constraint->group) {
            if (!isset($value['paymentProcessor'])) {
                $this->addViolation($constraint->missingFieldsMessage, PurchaseDetailsInput::PAYMENT_PROCESSOR);

                return;
            }

            if (null === $value['paymentProcessor'] || '' === $value['paymentProcessor']) {
                $this->addViolation($constraint->notBlankMessage, PurchaseDetailsInput::PAYMENT_PROCESSOR);

                return;
            }
        }

        return;
    }

    private function addViolation(string $message, string $path): void
    {
        $this->context->buildViolation($message)
            ->atPath($path)
            ->addViolation()
        ;
    }
}
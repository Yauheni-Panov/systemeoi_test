<?php

namespace App\Validator\Constraints;

use App\Model\PurchaseDetailsInput;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class TaxNumberValidator extends ConstraintValidator
{
    private array $patterns = [
        'DE' => '\d{9}',
        'GR' => '\d{9}',
        'FR' => '([A-Z0-9]{2})\d{9}',
        'IT' => '\d{11}',
    ];

    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$constraint instanceof TaxNumber) {
            throw new UnexpectedTypeException($constraint, TaxNumber::class);
        }

        $countryCode = substr($value, 0, 2);
        $vatNum = substr($value, 2);

        if (!$this->isValidCountryCode($countryCode)) {

            $this->context->buildViolation($constraint->taxNumberMessage)
                ->atPath(PurchaseDetailsInput::TAX_NUMBER)
                ->addViolation();

            return;
        }

        if (0 === preg_match('/^(?:'.$this->patterns[$countryCode].')$/', $vatNum)) {

            $this->context->buildViolation($constraint->taxNumberMessage)
                ->atPath(PurchaseDetailsInput::TAX_NUMBER)
                ->addViolation()
            ;

            return;
        }
    }

    private function isValidCountryCode($value): bool
    {
        return isset($this->patterns[$value]);
    }
}
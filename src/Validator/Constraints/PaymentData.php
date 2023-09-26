<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class PaymentData extends Constraint
{
    const GROUP_PURCHASE = 'purchase';

    public string $notBlankMessage = "The field must not be empty";
    public string $missingFieldsMessage = "This field is missing.";
    public string $extraFieldsMessage = 'This field was not expected.';
    public string $taxNumberMessage = "Incorrect tax number format";

    public function __construct(
        public ?string $group = null,
        array $groups = null,
        mixed $payload = null,
    )
    {
        parent::__construct([] , $groups = null, $payload = null);
    }
}
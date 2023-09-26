<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class TaxNumber extends Constraint
{
    public string $taxNumberMessage = "Incorrect tax number format";
}
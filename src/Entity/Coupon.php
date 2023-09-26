<?php

namespace App\Entity;

use App\Repository\CouponRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouponRepository::class)]
class Coupon
{
    const FIXED_AMOUNT_DISCOUNT = "FIXED_AMOUNT_DISCOUNT";
    const PERCENTAGE_DISCOUNT = "PERCENTAGE_DISCOUNT";

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $code;

    #[ORM\Column(length: 255)]
    private string $type;

    #[ORM\Column]
    private int $quantity;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function isPercentageDiscountType(): bool
    {
        return $this->type === self::PERCENTAGE_DISCOUNT;
    }

    public function isFixedAmountDiscountType(): bool
    {
        return $this->type == self::FIXED_AMOUNT_DISCOUNT;
    }
}

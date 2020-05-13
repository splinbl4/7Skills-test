<?php

declare(strict_types=1);

namespace App\Module\Sale\Entity\Receipt;

use Webmozart\Assert\Assert;

/**
 * Class Total
 * @package App\Module\Sale\Entity\Receipt
 */
class Total
{
    private float $value;

    public function __construct(float $value)
    {
        Assert::notEmpty($value);
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }
}

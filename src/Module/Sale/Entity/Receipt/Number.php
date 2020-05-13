<?php

declare(strict_types=1);

namespace App\Module\Sale\Entity\Receipt;

use Webmozart\Assert\Assert;

/**
 * Class Number
 * @package App\Module\Sale\Entity\Receipt
 */
class Number
{
    private string $value;

    public function __construct(string $value)
    {
        Assert::notEmpty($value);
        $this->value = mb_strtolower($value);
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}

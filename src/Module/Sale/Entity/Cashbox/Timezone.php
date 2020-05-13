<?php

declare(strict_types=1);

namespace App\Module\Sale\Entity\Cashbox;

use Webmozart\Assert\Assert;

/**
 * Class Timezone
 * @package App\Module\Sale\Entity\Cashbox
 */
class Timezone
{
    private int $value;

    public function __construct(int $value)
    {
        Assert::notEmpty($value);
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }
}

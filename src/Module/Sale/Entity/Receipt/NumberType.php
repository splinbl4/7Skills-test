<?php

declare(strict_types=1);

namespace App\Module\Sale\Entity\Receipt;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

/**
 * Class NumberType
 * @package App\Module\Sale\Entity\Receipt
 */
class NumberType extends StringType
{
    public const NAME = 'sale_receipts_number';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof Number ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? new Number((string)$value) : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}

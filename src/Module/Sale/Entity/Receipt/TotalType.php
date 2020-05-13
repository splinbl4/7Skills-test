<?php

declare(strict_types=1);

namespace App\Module\Sale\Entity\Receipt;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\FloatType;

/**
 * Class TotalType
 * @package App\Module\Sale\Entity\Receipt
 */
class TotalType extends FloatType
{
    public const NAME = 'sale_receipts_total';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof Total ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? new Total((float)$value) : null;
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

<?php

declare(strict_types=1);

namespace App\Module\Sale\Entity\Cashbox;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;

/**
 * Class TimezoneType
 * @package App\Module\Sale\Entity\Cashbox\
 */
class TimezoneType extends IntegerType
{
    public const NAME = 'sale_cashbox_timezone';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof Timezone ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? new Timezone((int)$value) : null;
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

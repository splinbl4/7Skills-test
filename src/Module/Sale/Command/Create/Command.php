<?php

declare(strict_types=1);

namespace App\Module\Sale\Command\Create;

use DateTimeImmutable;
use JMS\Serializer\Annotation\Type;

/**
 * Class Command
 * @package App\Module\Sale\Command\Create
 */
class Command
{
    /**
     * @Type("string")
     */
    public string $number;

    /**
     * @Type("integer")
     */
    public int $cashboxId;

    /**
     * @Type("DateTimeImmutable<'Y-m-d H:i:s'>")
     */
    public DateTimeImmutable $date;

    /**
     * @Type("float")
     */
    public float $total;
}

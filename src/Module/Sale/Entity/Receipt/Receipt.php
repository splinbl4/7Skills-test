<?php

declare(strict_types=1);

namespace App\Module\Sale\Entity\Receipt;

use App\Module\Sale\Entity\Cashbox\Cashbox;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\GeneratedValue;

/**
 * Class Receipt
 * @package App\Module\Sale\Entity\Receipt
 *
 * @ORM\Entity
 * @ORM\Table(name="sale_receipts")
 */
class Receipt
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @GeneratedValue
     */
    private int $id;

    /**
     * @ORM\Column(type="sale_receipts_number")
     */
    private Number $number;

    /**
     * @ORM\ManyToOne(targetEntity="App\Module\Sale\Entity\Cashbox\Cashbox")
     * @ORM\JoinColumn(name="cashbox_id", referencedColumnName="id", nullable=false)
     */
    private Cashbox $cashbox;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $date;

    /**
     * @ORM\Column(type="sale_receipts_total")
     */
    private Total $total;

    public function __construct(
        Number $number,
        Cashbox $cashbox,
        DateTimeImmutable $date,
        Total $total
    ) {
        $this->number = $number;
        $this->cashbox = $cashbox;
        $this->date = $date;
        $this->total = $total;
        $this->id = 1;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Number
     */
    public function getNumber(): Number
    {
        return $this->number;
    }

    /**
     * @return Cashbox
     */
    public function getCashbox(): Cashbox
    {
        return $this->cashbox;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return Total
     */
    public function getTotal(): Total
    {
        return $this->total;
    }
}

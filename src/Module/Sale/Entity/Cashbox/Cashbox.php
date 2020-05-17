<?php

declare(strict_types=1);

namespace App\Module\Sale\Entity\Cashbox;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\GeneratedValue;
use Webmozart\Assert\Assert;

/**
 * Class Cashbox
 * @package App\Module\Sale\Entity\Cashbox
 *
 * @ORM\Entity
 * @ORM\Table(name="sale_cashbox")
 */
class Cashbox
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @GeneratedValue
     */
    private int $id;

    /**
     * @ORM\Column(type="sale_cashbox_timezone")
     */
    private Timezone $timezone;

    /**
     * @ORM\Column(type="string")
     */
    private string $title;

    public function __construct(Timezone $timezone, string $title)
    {
        $this->timezone = $timezone;
        Assert::notEmpty($title);
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Timezone
     */
    public function getTimezone(): Timezone
    {
        return $this->timezone;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}

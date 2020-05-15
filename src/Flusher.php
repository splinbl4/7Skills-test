<?php

declare(strict_types=1);

namespace App;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class Flusher
 * @package App
 */
class Flusher
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function flush(): void
    {
        $this->em->flush();
    }
}

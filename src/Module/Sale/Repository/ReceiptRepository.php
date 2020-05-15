<?php

declare(strict_types=1);

namespace App\Module\Sale\Repository;

use App\Module\Sale\Entity\Receipt\Receipt;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class ReceiptRepository
 * @package App\Module\Sale\Repository
 */
class ReceiptRepository
{
    private EntityManagerInterface $em;

    private EntityRepository $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repo = $em->getRepository(Receipt::class);
    }

    public function add(Receipt $receipt): void
    {
        $this->em->persist($receipt);
    }
}

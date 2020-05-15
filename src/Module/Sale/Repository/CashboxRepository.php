<?php

declare(strict_types=1);

namespace App\Module\Sale\Repository;

use App\Module\Sale\Entity\Cashbox\Cashbox;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class CashboxRepository
 * @package App\Module\Sale\Repository
 */
class CashboxRepository
{
    private EntityManagerInterface $em;

    private EntityRepository $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repo = $em->getRepository(Cashbox::class);
    }

    public function findAll(): array
    {
        return $this->repo->findAll();
    }

    /**
     * @param int $id
     * @return null|object|Cashbox
     */
    public function findById(int $id): Cashbox
    {
        return $this->repo->findOneBy(['id' => $id]);
    }

    public function findByIds(array $ids)
    {
        return $this->repo->findBy(['id' => $ids]);
    }
}
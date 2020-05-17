<?php

declare(strict_types=1);

namespace App\Module\Sale\ReadModel;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

/**
 * Class ReceiptFetcher
 * @package App\Module\Sale\Repository
 */
class ReceiptFetcher
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function find(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'year(date) as year', 'month(date) as month',
                'sc.title as cashbox_title',
                'ROUND(SUM(sr.total), 2) as total'
            )
            ->from('sale_receipts', 'sr')
            ->join('sr', 'sale_cashbox', 'sc', 'sr.cashbox_id = sc.id')
            ->groupBy( 'sc.title', 'year(date)', 'month(date)')
            ->execute();

        $stmt->setFetchMode(FetchMode::ASSOCIATIVE);

        return $stmt->fetchAll();
    }

    public function findByMonthAndYear(int $month, int $year): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'DATE_FORMAT(sr.date, \'%d.%m.%Y\') as date',
                'sc.title as cashbox_title',
                'sc.id as cashbox_id',
                'ROUND(SUM(sr.total), 2) as total'
            )
            ->from('sale_receipts', 'sr')
            ->join('sr', 'sale_cashbox', 'sc', 'sr.cashbox_id = sc.id')
            ->where('month(sr.date) = :month', 'year(sr.date) = :year')
            ->setParameter(':month', $month)
            ->setParameter(':year', $year)
            ->groupBy('DATE_FORMAT(date, \'%d.%m.%Y\')', 'sc.title', 'sc.id')
            ->execute();

        $stmt->setFetchMode(FetchMode::ASSOCIATIVE);

        return $stmt->fetchAll();
    }
}

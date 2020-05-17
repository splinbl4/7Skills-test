<?php

declare(strict_types=1);

namespace App\Controller\Sale;

use App\Module\Sale\ReadModel\ReceiptFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ReceiptController
 * @package App\Controller\Sale
 *
 * @Route("/sale/receipts", name="sale.receipts")
 */
class ReceiptController extends AbstractController
{
    /**
     * @param ReceiptFetcher $fetcher
     * @return Response
     *
     * @Route("/", methods={"GET"})
     */
    public function index(ReceiptFetcher $fetcher): Response
    {
        $result = $fetcher->find();

        return $this->json([
            'result' => $result
        ]);
    }

    /**
     * @param int $month
     * @param $year
     * @param ReceiptFetcher $fetcher
     * @return Response
     *
     * @Route("/month/{month}/year/{year}", methods={"GET"})
     */
    public function getByMonths(int $month, int $year, ReceiptFetcher $fetcher): Response
    {
        $result = $fetcher->findByMonthAndYear($month, $year);

        return $this->json([
            'result' => $result
        ]);
    }
}

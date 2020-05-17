<?php

declare(strict_types=1);

namespace App\Module\Sale\Command\Create;

use App\Module\Sale\Entity\Cashbox\Cashbox;
use App\Module\Sale\Entity\Receipt\Number;
use App\Module\Sale\Entity\Receipt\Receipt;
use App\Module\Sale\Entity\Receipt\Total;
use App\Module\Sale\Repository\ReceiptRepository;

/**
 * Class Handler
 * @package App\Module\Sale\Command\Create
 */
class Handler
{
    private ReceiptRepository $receiptRepository;

    public function __construct(ReceiptRepository $receiptRepository)
    {
        $this->receiptRepository = $receiptRepository;
    }

    public function handle(Command $command, Cashbox $cashbox)
    {
        $receipt = new Receipt(
            new Number($command->number),
            $cashbox,
            $command->date,
            new Total($command->total)
        );

        $this->receiptRepository->add($receipt);
    }
}

<?php

declare(strict_types=1);

namespace App\Module\Sale\QueueBroker\Consumer;

use App\Flusher;
use App\Module\Sale\Command\Create\Command;
use App\Module\Sale\Entity\Cashbox\Cashbox;
use App\Module\Sale\Entity\Receipt\Number;
use App\Module\Sale\Entity\Receipt\Receipt;
use App\Module\Sale\Entity\Receipt\Total;
use App\Module\Sale\Repository\CashboxRepository;
use App\Module\Sale\Repository\ReceiptRepository;
use App\Utils\ArrayTools;
use ArrayIterator;
use Exception;
use JMS\Serializer\SerializerInterface;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerAwareTrait;

/**
 * Class ReceiptImportConsumer
 * @package App\Module\Sale\QueueBroker\Consumer
 */
class ReceiptGeneratorConsumer implements ConsumerInterface
{
    use LoggerAwareTrait;

    private const BATCH_SIZE = 100;

    private ReceiptRepository $receiptRepository;

    private SerializerInterface $serializer;

    private Flusher $flusher;

    private CashboxRepository $cashboxRepository;

    public function __construct(
        ReceiptRepository $receiptRepository,
        CashboxRepository $cashboxRepository,
        SerializerInterface $serializer,
        Flusher $flusher
    ) {
        $this->receiptRepository = $receiptRepository;
        $this->serializer = $serializer;
        $this->flusher = $flusher;
        $this->cashboxRepository = $cashboxRepository;
    }

    /**
     * @param AMQPMessage $msg
     * @return mixed|void
     * @throws Exception
     */
    public function execute(AMQPMessage $msg)
    {
        /** @var Command[] $commands **/
        $commands = $this->serializer->deserialize(
            $msg->getBody(),
            'array<App\Module\Sale\Command\Create\Command>',
            'json'
        );

        $cashboxes = $this->getCashboxes($commands);

        $commandsIterator = new ArrayIterator($commands);

        try {
            foreach (ArrayTools::chunk($commandsIterator, self::BATCH_SIZE) as $commandChunk) {
                foreach ($commandChunk as $command) {
                    $receipt = new Receipt(
                        new Number($command->number),
                        $cashboxes[$command->cashboxId],
                        $command->date,
                        new Total($command->total)
                    );

                    $this->receiptRepository->add($receipt);
                }
                $this->flusher->flush();
            }

        } catch (Exception $exception) {
            $this->logger->error(
                $exception->getMessage(),
                ['body' => $this->serializer->serialize($commands, 'json')]
            );

            return self::MSG_REJECT;
        }

        return self::MSG_ACK;
    }

    private function getCashboxes(array $commands)
    {
        $cashboxIds = array_unique(array_map(function ($command) {
            return $command->cashboxId;
        }, $commands));

        $cashboxes = [];
        foreach ($cashboxIds as $cashboxId) {
            $cashbox = $this->cashboxRepository->findById($cashboxId);
            if (!$cashbox instanceof Cashbox) {
                $this->logger->error(
                    "Cashbox not found '$cashboxId'",
                    ['body' => $this->serializer->serialize($commands, 'json')]
                );

                return self::MSG_REJECT;
            }

            $cashboxes[$cashboxId] = $cashbox;
        }

        return $cashboxes;
    }
}

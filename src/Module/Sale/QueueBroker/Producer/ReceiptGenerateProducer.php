<?php

declare(strict_types=1);

namespace App\Module\Sale\QueueBroker\Producer;

use App\Module\Sale\Command\Create\Command;
use JMS\Serializer\SerializerInterface;
use OldSound\RabbitMqBundle\RabbitMq\Producer;

/**
 * Class ReceiptImportProducer
 * @package App\Module\Sale\QueueBroker\Producer
 */
class ReceiptGenerateProducer
{
    private Producer $producer;

    private SerializerInterface $serializer;

    public function __construct(Producer $producer, SerializerInterface $serializer)
    {
        $this->producer = $producer;
        $this->serializer = $serializer;
    }

    /**
     * @param Command[] $commands
     */
    public function enqueue(array $commands)
    {
        $this->producer->publish($this->serializer->serialize($commands, 'json'));
    }
}

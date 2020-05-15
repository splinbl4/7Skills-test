<?php

declare(strict_types=1);

namespace App\Command\Module\Sale;

use App\Module\Sale\Entity\Cashbox\Cashbox;
use App\Module\Sale\QueueBroker\Producer\ReceiptGenerateProducer;
use App\Module\Sale\Repository\CashboxRepository;
use App\Utils\ArrayTools;
use ArrayIterator;
use DateTime;
use DateTimeImmutable;
use Faker\Factory;
use JMS\Serializer\SerializerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReceiptGenerateCommand extends Command
{
    private const BATCH_SIZE = 100;

    private CashboxRepository $cashboxRepository;

    private SerializerInterface $serializer;

    private ReceiptGenerateProducer $producer;

    public function __construct(
        CashboxRepository $cashboxRepository,
        SerializerInterface $serializer,
        ReceiptGenerateProducer $producer,
        string $name = null)
    {
        parent::__construct($name);
        $this->cashboxRepository = $cashboxRepository;
        $this->serializer = $serializer;
        $this->producer = $producer;
    }

    protected function configure(): void
    {
        $this
            ->setName('receipts:generate')
            ->setDescription('Generate receipts');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $faker = Factory::create();
        $cashboxes = $this->cashboxRepository->findAll();

        $date = (new DateTime())->setTime(0, 0, 0);

        for ($i = 0; $i < 365; $i++) {
            $commands = [];
            $date = new DateTimeImmutable($date->modify('+ 1 day')->format('Y-m-d H:i:s'));

            for ($j = 0; $j < $faker->numberBetween(400, 800); $j++) {
                /**@var Cashbox $cashbox **/
                $cashbox = $faker->randomElement($cashboxes);
                $dateModify = $date->modify('+' . $faker->numberBetween(6, 21) . ' hours ' . $faker->numberBetween(0, 59) . 'minutes');

                $command = new \App\Module\Sale\Command\Create\Command();
                $command->number = Uuid::uuid4()->toString();
                $command->cashboxId = $cashbox->getId();
                $command->date = $dateModify;
                $command->total = $faker->randomFloat(2, 80, 150);

                $commands[] = $command;
            }

            $commandsIterator = new ArrayIterator($commands);
            foreach (ArrayTools::chunk($commandsIterator, self::BATCH_SIZE) as $commandChunk) {
                $this->producer->enqueue($commandChunk);
            }
        }

        $output->writeln('<info>Done!</info>');

        return 0;
    }
}

<?php

namespace App\Trigger;

use App\Entity\MarketPrice;
use App\TriggerInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DifferenceTrigger implements TriggerInterface
{
    /**
     * @var ManagerRegistry
     */
    private $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @param Command $command
     */
    public function addInput(Command $command): void
    {
        $command
            ->addOption(
                'difference',
                null,
                InputOption::VALUE_OPTIONAL,
                'Percent difference within the last hour, before triggered'
            )
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @param MarketPrice     $marketPrice
     *
     * @return array|null
     *
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    public function run(InputInterface $input, OutputInterface $output, MarketPrice $marketPrice): ?array
    {
        if ($input->getOption('difference')) {
            $prices = $this->registry->getRepository(MarketPrice::class)
                ->getHourPrices($input->getArgument('coin'), $input->getArgument('parser'))
            ;

            foreach ($prices as $price) {
                $diff = ($price * $input->getOption('difference')) / 100;
                $event = null;
                if ($marketPrice->getPrice() >= $diff) {
                    return [
                        'difference' => $marketPrice->getPrice() - $diff,
                    ];
                }

                if ($marketPrice->getPrice() <= $diff) {
                    return [
                        'difference' => $diff - $marketPrice->getPrice(),
                    ];
                }
            }
        }

        return null;
    }

    /**
     * The event name to send.
     *
     * @return string
     */
    public static function getEventName(): string
    {
        return 'difference';
    }
}

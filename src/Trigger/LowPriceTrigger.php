<?php

namespace App\Trigger;

use App\Entity\MarketPrice;
use App\TriggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class LowPriceTrigger implements TriggerInterface
{

    /**
     * @param Command $command
     */
    public function addInput(Command $command): void
    {
        $command
            ->addOption(
                'lowprice',
                null,
                InputOption::VALUE_OPTIONAL,
                'Low price before triggered (in selected currency - without decimals, in lowest fraction)'
            )
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param MarketPrice $marketPrice
     * @return array|null
     *
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    public function run(InputInterface $input, OutputInterface $output, MarketPrice $marketPrice): ?array
    {
        if ($input->getOption('lowprice')) {
            if ($marketPrice->getPrice() <= $input->getOption('lowprice')) {
                return [
                    'lowprice' => $input->getOption('lowprice'),
                ];
            }
        }

        return null;
    }

    /**
     * The event name to send
     *
     * @return string
     */
    public static function getEventName(): string
    {
        return 'low';
    }
}
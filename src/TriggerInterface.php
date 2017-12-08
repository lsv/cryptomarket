<?php

namespace App;

use App\Entity\MarketPrice;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface TriggerInterface
{
    /**
     * Add configuration to the command.
     *
     * @param Command $command
     */
    public function addInput(Command $command): void;

    /**
     * The actual run command
     * If a array is returned, an event will be dispatched.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @param MarketPrice     $marketPrice
     *
     * @return null|array
     */
    public function run(InputInterface $input, OutputInterface $output, MarketPrice $marketPrice): ?array;

    /**
     * The event name to send.
     *
     * @return string
     */
    public static function getEventName(): string;
}

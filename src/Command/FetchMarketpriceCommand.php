<?php

namespace App\Command;

use App\Service;
use App\TriggerService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FetchMarketpriceCommand extends Command
{
    public static $defaultName = 'fetch:marketprice';

    /**
     * @var TriggerService
     */
    private $trigger;

    /**
     * @var Service
     */
    private $service;

    public function __construct(TriggerService $trigger, Service $service)
    {
        $this->trigger = $trigger;
        $this->service = $service;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Fetch market prices')
            ->addOption('currency', null, InputOption::VALUE_OPTIONAL, 'Which currency do you want the price at', 'USD')
            ->addOption('maxtriggers', 'mt', InputOption::VALUE_OPTIONAL, 'Maximum trigger pr hour')
            ->addArgument('coin', InputArgument::OPTIONAL, 'The coin type you want to fetch', 'BTC')
            ->addArgument('parser', InputArgument::OPTIONAL, 'Parser to use', 'cryptocompare')
        ;

        $this->trigger->setInput($this);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->service->run($input, $output);
    }
}

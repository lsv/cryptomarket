<?php

namespace App\Event;

use App\Entity\MarketPrice;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\Event;

class TriggerEvent extends Event
{

    public const EVENT_NAME = 'app.trigger';

    /**
     * @var MarketPrice
     */
    private $marketPrice;

    /**
     * @var array
     */
    private $data;

    /**
     * @var OutputInterface
     */
    private $output;

    public function __construct(OutputInterface $output, MarketPrice $marketPrice, array $data)
    {
        $this->marketPrice = $marketPrice;
        $this->data = $data;
        $this->output = $output;
    }

    /**
     * @return MarketPrice
     */
    public function getMarketPrice(): MarketPrice
    {
        return $this->marketPrice;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return OutputInterface
     */
    public function getOutput(): OutputInterface
    {
        return $this->output;
    }

}
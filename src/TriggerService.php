<?php

namespace App;

use App\Entity\MarketPrice;
use App\Event\TriggerEvent;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class TriggerService
{

    /**
     * @var TriggerInterface[]
     */
    private $triggers = [];
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param TriggerInterface $trigger
     */
    public function addTrigger(TriggerInterface $trigger): void
    {
        $this->triggers[] = $trigger;
    }

    /**
     * @return TriggerInterface[]
     */
    public function getTriggers(): array
    {
        return $this->triggers;
    }

    /**
     * @param Command $command
     */
    public function setInput(Command $command): void
    {
        foreach ($this->getTriggers() as $trigger) {
            $trigger->addInput($command);
        }
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param MarketPrice $price
     */
    public function run(InputInterface $input, OutputInterface $output, MarketPrice $price): void
    {
        foreach ($this->triggers as $trigger) {
            $return = $trigger->run($input, $output, $price);
            if ($return) {
                $event = new TriggerEvent($output, $price, $return);
                $this->dispatcher->dispatch(
                    $event::EVENT_NAME,
                    $event
                );

                $this->dispatcher->dispatch(
                    sprintf('%s.%s', $event::EVENT_NAME, $trigger::getEventName()),
                    $event
                );
            }
        }
    }

}
<?php

namespace App;

use App\Entity\MarketPrice;
use App\Entity\Triggers;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Intl\Intl;

class Service
{

    /**
     * @var ParserService
     */
    private $parser;

    /**
     * @var ManagerRegistry
     */
    private $registry;

    /**
     * @var TriggerService
     */
    private $trigger;

    /**
     * @param TriggerService $trigger
     * @param ParserService $parser
     * @param ManagerRegistry $registry
     */
    public function __construct(TriggerService $trigger, ParserService $parser, ManagerRegistry $registry)
    {
        $this->parser = $parser;
        $this->registry = $registry;
        $this->trigger = $trigger;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     * @throws ParserException
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function run(InputInterface $input, OutputInterface $output): void
    {
        if (! $em = $this->registry->getManagerForClass(MarketPrice::class)) {
            $output->writeln('Could not connect to manager');
        }

        $coin = strtoupper($input->getArgument('coin'));
        $currency = strtoupper($input->getOption('currency'));
        $decimals = Intl::getCurrencyBundle()->getFractionDigits($currency);
        $marketPrice = $this->parser->getParser($input->getArgument('parser'), $coin, $currency, $decimals);
        if ($this->canTrigger($input)) {
            $this->trigger->run($input, $output, $marketPrice);
        }

        $em->persist($marketPrice);
        $em->flush();
    }

    /**
     * @param InputInterface $input
     * @return bool
     *
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    private function canTrigger(InputInterface $input): bool
    {
        $triggers = $this->registry->getRepository(Triggers::class)
            ->getNumberOfTriggersLastHour($input->getArgument('coin'), $input->getArgument('parser'))
        ;
        return $triggers <= $input->getOption('maxtriggers');
    }

}
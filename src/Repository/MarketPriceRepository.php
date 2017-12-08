<?php

namespace App\Repository;

use App\Entity\MarketPrice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class MarketPriceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MarketPrice::class);
    }

    /**
     * @param string $coin
     * @param string $parser
     * @param int    $hour
     *
     * @return array
     */
    public function getHourPrices(string $coin, string $parser, $hour = 1): array
    {
        $qb = $this->createQueryBuilder('market_price');
        $qb
            ->select('market_price.price')
            ->andWhere($qb->expr()->eq('market_price.type', ':coin'))
            ->andWhere($qb->expr()->gte('market_price.date', ':date'))
            ->andWhere($qb->expr()->gte('market_price.parser', ':parser'))
        ;
        $qb->setParameter(':coin', $coin);
        $qb->setParameter(':date', new \DateTime('-'.$hour.' hour'));
        $qb->setParameter(':parser', $parser);

        return $qb->getQuery()->getArrayResult();
    }
}

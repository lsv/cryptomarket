<?php

namespace App\Repository;

use App\Entity\Triggers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TriggersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Triggers::class);
    }

    /**
     * @param string $coin
     * @param string $market
     * @param int $hours
     *
     * @return int
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getNumberOfTriggersLastHour(string $coin, string $market, int $hours = 1): int
    {
        $qb = $this->createQueryBuilder('triggers');
        $qb
            ->select($qb->expr()->count('triggers.id'))
            ->andWhere($qb->expr()->eq('triggers.coin', ':coin'))
            ->andWhere($qb->expr()->gt('triggers.date', ':date'))
            ->andWhere($qb->expr()->eq('triggers.parser', ':parser'))
        ;
        $qb->setParameter(':coin', $coin);
        $qb->setParameter(':date', new \DateTime('-' . $hours . ' hour'));
        $qb->setParameter(':parser', $market);

        return (int) $qb->getQuery()->getSingleScalarResult();
    }
}

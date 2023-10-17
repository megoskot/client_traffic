<?php

namespace App\ClientTraffic\Repository;

use App\ClientTraffic\Entity\Client;
use App\ClientTraffic\Entity\ClientMonthLimit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ClientMonthLimitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClientMonthLimit::class);
    }

    /**
     * @param Client $client
     * @return ClientMonthLimit
     */
    public function findClientCurrentMonthLimit(Client $client): ClientMonthLimit
    {
        $query = $this->createQueryBuilder('ml');

        return $query
            ->andWhere($query->expr()->andX(
                $query->expr()->eq('ml.client', $client),
                $query->expr()->eq('m.date', new \DateTimeImmutable())
            ))->getQuery()->getOneOrNullResult();
    }
}
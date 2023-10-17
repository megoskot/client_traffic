<?php

namespace App\ClientTraffic\Repository;

use App\ClientTraffic\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    /**
     * @return iterable<Client>
     */
    public function getAll(): iterable
    {
        return $this->getAll();
    }

    /**
     * @param Client $client
     * @return void
     */
    public function save(Client $client): void
    {
        $this->_em->persist($client);
        $this->_em->flush();
    }

    /**
     * @param Client $client
     * @return void
     */
    public function detach(Client $client): void
    {
        $this->_em->detach($client);
    }
}
<?php

namespace App\ClientTraffic\Repository;

use App\ClientTraffic\Entity\Client;
use App\ClientTraffic\Entity\ClientPacket;
use App\ClientTraffic\Exception\ClientPacketNotFound;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

class ClientPacketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClientPacket::class);
    }

    /**
     * @param int $packetId
     * @return ClientPacket
     * @throws ClientPacketNotFound
     */
    public function findByPacketId(int $packetId): ClientPacket
    {
        try {
            $query = $this->createQueryBuilder('p');
            $packet = $query
                ->andWhere($query->expr()->eq('p.packetId', $packetId))
                ->getQuery()->getOneOrNullResult();

            return $packet ?: throw new ClientPacketNotFound();
        } catch (NonUniqueResultException $e) {
            throw new \LogicException(__METHOD__ . $e->getMessage(), previous: $e);
        }
    }

    /**
     * @param Client $client
     * @return ClientPacket
     * @throws ClientPacketNotFound
     */
    public function getLastClientPacket(Client $client): ClientPacket
    {
        try {
            $query = $this->createQueryBuilder('p');
            $packet = $query
                ->andWhere($query->expr()->eq('p.client', $client))
                ->orderBy('p.createdAt', 'DESC')
                ->setMaxResults(1)
                ->getQuery()->getOneOrNullResult();

            return $packet ?: throw new ClientPacketNotFound();
        } catch (NonUniqueResultException $e) {
            throw new \LogicException(__METHOD__ . $e->getMessage(), previous: $e);
        }
    }
}
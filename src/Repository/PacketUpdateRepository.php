<?php

namespace App\ClientTraffic\Repository;

use App\ClientTraffic\Entity\ClientPacket;
use App\ClientTraffic\Entity\PacketUpdate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PacketUpdateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PacketUpdate::class);
    }

    public function getLastPacketUpdate(ClientPacket $packet): PacketUpdate
    {
        $query = $this->createQueryBuilder('pu');

        return $query
            ->andWhere($query->expr()->eq('pu.packetId', ":packetId"))
            ->setParameter('packetId', $packet->getPacketId())
            ->orderBy('pu.timestamp', 'DESC')
            ->setMaxResults(1)
            ->getQuery()->getOneOrNullResult();
    }

    public function save(PacketUpdate $update): void
    {
        $this->_em->persist($update);
        $this->_em->flush();
    }
}
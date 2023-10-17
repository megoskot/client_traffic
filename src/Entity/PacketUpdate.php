<?php

namespace App\ClientTraffic\Entity;

use App\ClientTraffic\Repository\PacketUpdateRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Table(name: 'packets_updates')]
#[Entity(repositoryClass: PacketUpdateRepository::class)]
class PacketUpdate
{
    #[Id, GeneratedValue(strategy: 'AUTO'), Column(type: Types::INTEGER)]
    private int $id;
    #[Column(name: 'used', type: Types::INTEGER, nullable: false)]
    private int $used;
    #[Column(name: 'limit', type: Types::INTEGER, nullable: false)]
    private int $limit;
    #[Column(name: 'packet_id', type: Types::INTEGER, nullable: false)]
    private int $packetId;
    #[Column(name: 'timestamp', type: Types::DATETIME_IMMUTABLE, nullable: false)]
    private DateTimeImmutable $timestamp;

    public function __construct(int $packetId, int $limit, int $used)
    {
        $this->timestamp = new DateTimeImmutable();
        $this->packetId = $packetId;
        $this->limit = $limit;
        $this->used = $used;
    }

    /**
     * @return int
     */
    public function getUsed(): int
    {
        return $this->used;
    }

    public function isUsed(): bool
    {
        return $this->used >= $this->limit;
    }

    public function trafficDiff(PacketUpdate $previousUpdate): int
    {
        return $this->used - $previousUpdate->getUsed();
    }
}
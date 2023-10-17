<?php

namespace App\ClientTraffic\Entity;

use App\ClientTraffic\Repository\ClientPacketRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;

#[Table(name: 'clients_packets')]
#[Entity(repositoryClass: ClientPacketRepository::class)]
#[UniqueConstraint(name: 'packet_uidx', columns: ['packet_id'])]
class ClientPacket
{
    #[Id, GeneratedValue(strategy: 'AUTO'), Column(type: Types::INTEGER)]
    private int $id;
    #[Column(name: 'packet_id', type: Types::INTEGER, nullable: false)]
    private int $packetId;
    #[ManyToOne(targetEntity: Client::class, inversedBy: 'packets')]
    #[JoinColumn(name: 'client_id', referencedColumnName: 'id')]
    private Client $client;
    #[Column(name: 'created_at', type: Types::DATE_IMMUTABLE, nullable: false)]
    private DateTimeImmutable $createdAt;

    public function __construct(Client $client, int $packetId)
    {
        $this->client = $client;
        $this->packetId = $packetId;
        $this->createdAt = new DateTimeImmutable();
    }

    /**
     * @return int
     */
    public function getPacketId(): int
    {
        return $this->packetId;
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
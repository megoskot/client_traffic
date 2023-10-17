<?php

namespace App\ClientTraffic\Entity;

use App\ClientTraffic\Repository\ClientRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Table(name: 'clients')]
#[Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[Id, GeneratedValue(strategy: 'AUTO'), Column(type: Types::INTEGER)]
    private int $id;
    #[Column(name: 'name', type: Types::STRING, nullable: false)]
    private string $name;
    #[OneToMany(mappedBy: 'client', targetEntity: ClientMonthLimit::class, cascade: ['persist'])]
    private Collection $limits;
    #[OneToMany(mappedBy: 'client', targetEntity: ClientPacket::class, cascade: ['persist'])]
    private Collection $packets;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function initMonthLimit(DateTimeImmutable $date, int $limit = 40): void
    {
        $this->limits->add(new ClientMonthLimit($this, $date, $limit));
    }

    public function addPacket(int $packetId): void
    {
        $this->packets->add(new ClientPacket($this, $packetId));
    }
}
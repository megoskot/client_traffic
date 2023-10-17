<?php

namespace App\ClientTraffic\Entity;

use App\ClientTraffic\Repository\ClientMonthLimitRepository;
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

#[Table(name: 'clients_months_limit')]
#[Entity(repositoryClass: ClientMonthLimitRepository::class)]
#[UniqueConstraint(name: 'client_date_uidx', columns: ['client_id', 'date'])]
class ClientMonthLimit
{
    #[Id, GeneratedValue(strategy: 'AUTO'), Column(type: Types::INTEGER)]
    private int $id;
    #[Column(name: 'used', type: Types::INTEGER, nullable: false)]
    private int $used;
    #[Column(name: 'limit', type: Types::INTEGER, nullable: false)]
    private int $limit;
    #[ManyToOne(targetEntity: Client::class, inversedBy: 'limits')]
    #[JoinColumn(name: 'client_id', referencedColumnName: 'id')]
    private Client $client;
    #[Column(name: 'date', type: Types::DATE_IMMUTABLE, nullable: false)]
    private DateTimeImmutable $date;

    public function __construct(Client $client, DateTimeImmutable $date, int $limit)
    {
        $this->client = $client;
        $this->date = $date;
        $this->limit = $limit;
        $this->used = 0;
    }

    public function use($traffic): void
    {
        $this->used += $traffic;
    }
}
<?php

namespace App\ClientTraffic\UseCases;

use App\ClientTraffic\Entity\Client;
use App\ClientTraffic\Exception\ClientPacketNotFound;
use App\ClientTraffic\Repository\ClientPacketRepository;
use App\ClientTraffic\Repository\ClientRepository;
use App\ClientTraffic\Repository\PacketUpdateRepository;
use App\ClientTraffic\Services\Operator;
use DateTimeImmutable;

class InitClientMonth
{
    public function __construct(
        private readonly ClientRepository $clientRepository,
        private readonly ClientPacketRepository $clientPacketRepository,
        private readonly PacketUpdateRepository $packetUpdateRepository
    ) {
    }

    public function onStartMonth(Client $client): void
    {
        $currentDate = new DateTimeImmutable();
        $client->initMonthLimit($currentDate);

        try {
            $packet = $this->clientPacketRepository->getLastClientPacket($client);
            $packetUpdate = $this->packetUpdateRepository->getLastPacketUpdate($packet);
            if ($packetUpdate->isUsed()) {
                $client->addPacket(Operator::createPacket($client->getId()));
            }
        } catch (ClientPacketNotFound) {
            $client->addPacket(Operator::createPacket($client->getId()));
        }

        $this->clientRepository->save($client);
        $this->clientRepository->detach($client);
    }
}
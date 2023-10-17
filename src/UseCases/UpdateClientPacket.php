<?php

namespace App\ClientTraffic\UseCases;

use App\ClientTraffic\Entity\PacketUpdate;
use App\ClientTraffic\Repository\ClientMonthLimitRepository;
use App\ClientTraffic\Repository\ClientPacketRepository;
use App\ClientTraffic\Repository\PacketUpdateRepository;
use App\ClientTraffic\Services\Operator;

class UpdateClientPacket
{
    public function __construct(
        private readonly ClientPacketRepository $clientPacketRepository,
        private readonly PacketUpdateRepository $packetUpdateRepository,
        private readonly ClientMonthLimitRepository $clientLimitRepository,

    ) {
    }

    public function onUpdatePacket(int $packetId, int $limit, int $used): void
    {
        $currentUpdate = new PacketUpdate($packetId, $limit, $used);

        $packet = $this->clientPacketRepository->findByPacketId($packetId);
        $previousUpdate = $this->packetUpdateRepository->getLastPacketUpdate($packet);
        $clientCurrentLimit = $this->clientLimitRepository->findClientCurrentMonthLimit($packet->getClient());
        $clientCurrentLimit->use($currentUpdate->trafficDiff($previousUpdate));

        if ($currentUpdate->isUsed()) {
            $packet->getClient()->addPacket(Operator::createPacket($packet->getClient()->getId()));
        }

        $this->packetUpdateRepository->save($currentUpdate);
    }
}
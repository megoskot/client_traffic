<?php

namespace App\ClientTraffic\Services;

class Operator
{
    /**
     * @param int $clientId
     * @return int
     */
    public static function createPacket(int $clientId): int
    {
        //TODO: Operator traffic packet request

        return rand();
    }
}
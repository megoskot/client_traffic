<?php

namespace App\ClientTraffic\Command;

use App\ClientTraffic\Repository\ClientRepository;
use App\ClientTraffic\UseCases\InitClientMonth;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MonthStartCommand extends Command
{
    protected static $defaultDescription = 'Initialization clients month limits';

    public function __construct(
        private readonly ClientRepository $clientRepository,
        private readonly InitClientMonth $useCase
    ) {
        parent::__construct('app:month:start');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->clientRepository->getAll() as $client) {
            $this->useCase->onStartMonth($client);
        }
    }
}
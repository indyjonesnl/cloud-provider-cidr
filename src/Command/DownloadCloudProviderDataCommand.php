<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\CidrService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:download', description: 'Download CIDR\'s for cloud providers.')]
final class DownloadCloudProviderDataCommand extends Command
{
    public function __construct(
        private readonly CidrService $cidrService,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $providers = $this->cidrService->getProviders();

        foreach ($providers as $provider) {
            $cidrList = $provider->getCidrList();
            $output->writeln('Downloaded ' . count($cidrList) . ' CIDR\'s from provider ' . $provider->getName() . '.');
            file_put_contents(__DIR__ . '/../../data/' . $provider->getName() . '.txt', implode(PHP_EOL, $cidrList));
        }

        return Command::SUCCESS;
    }
}

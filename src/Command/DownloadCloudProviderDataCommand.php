<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\CidrService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:download', description: 'Hello PhpStorm')]
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
        $cidrList = $this->cidrService->getCidrList('AWS');
        $output->writeln('Downloaded ' . count($cidrList) . ' CIDR\'s.');
        file_put_contents(__DIR__ . '/../../data/aws.txt', implode(PHP_EOL, $cidrList));

        return Command::SUCCESS;
    }
}

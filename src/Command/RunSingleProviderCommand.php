<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\CidrService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('app:single', 'Run a single provider.')]
final class RunSingleProviderCommand extends Command
{
    public function __construct(
        private readonly CidrService $cidrService,
    )
    {
        parent::__construct();
    }

    public function configure(): void
    {
        $this->addArgument('provider', InputArgument::REQUIRED, 'Provider name.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $providerName = $input->getArgument('provider');

        $cidrProvider = null;
        foreach ($this->cidrService->getProviders() as $provider) {
            if ($provider->getName() === $providerName) {
                $cidrProvider = $provider;
            }
        }

        if ($cidrProvider === null) {
            $output->writeln('<error>Could not find provider named "' . $providerName . '".</error>');
            return self::FAILURE;
        }

        $output->writeln('<info>Running provider now.</info>');
        $cidrList = $cidrProvider->getCidrList();
        $output->writeln('<info>Provider loaded ' . count($cidrList) . ' cidr addresses.</info>');
        $fileName = __DIR__ . '/../../data/single_run_' . $providerName . '.txt';
        file_put_contents($fileName, implode(PHP_EOL, $cidrList));
        $output->writeln('<info>Done writing cidr addresses to file: ' . realpath($fileName) . '</info>');

        return self::SUCCESS;
    }
}
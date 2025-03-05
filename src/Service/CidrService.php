<?php

declare(strict_types=1);

namespace App\Service;

use App\Provider\ProviderInterface;

final readonly class CidrService
{
    /** @param iterable<ProviderInterface> $providers */
    public function __construct(
        private iterable $providers,
    )
    {
    }

    /** @return iterable<ProviderInterface> */
    public function getProviders(): iterable
    {
        return $this->providers;
    }
}
<?php

declare(strict_types=1);

namespace App\Service;

use App\Provider\ProviderInterface;

final readonly class CidrService
{
    /** @param ProviderInterface[] $providers */
    public function __construct(
        private iterable $providers,
    )
    {
    }

    public function getCidrList(string $name): ?array
    {
        foreach($this->providers as $provider) {
            if ($provider->getName() === $name) {
                return $provider->getCidrList();
            }
        }

        return null;
    }
}
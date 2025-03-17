<?php

declare(strict_types=1);

namespace App\Provider;

final readonly class AkamaiProvider extends IpipProvider
{
    public function getName(): string
    {
        return 'akamai';
    }

    public function getUrls(): array
    {
        return ['https://whois.ipip.net/AS63949', 'https://whois.ipip.net/AS20940'];
    }
}
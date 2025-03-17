<?php

namespace App\Provider;

final readonly class StratoProvider extends IpipProvider
{
    public function getUrls(): array
    {
        return ['https://whois.ipip.net/AS6724'];
    }

    public function getName(): string
    {
        return 'strato';
    }
}
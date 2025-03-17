<?php

declare(strict_types=1);

namespace App\Provider;

final readonly class AlibabaCloudProvider extends IpipProvider
{
    public function getName(): string
    {
        return 'alibaba';
    }

    public function getUrls(): array
    {
        return ['https://whois.ipip.net/AS37963'];
    }
}
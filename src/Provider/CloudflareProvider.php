<?php

declare(strict_types=1);

namespace App\Provider;

final readonly class CloudflareProvider extends AbstractProvider
{
    public function getName(): string
    {
        return 'cloudflare';
    }

    public function getCidrList(): iterable
    {
        $cidrList = explode(PHP_EOL, $this->getContent('https://www.cloudflare.com/ips-v4'));
        sort($cidrList);
        return $cidrList;
    }
}
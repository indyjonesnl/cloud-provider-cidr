<?php

declare(strict_types=1);

namespace App\Provider;

final readonly class HetznerProvider extends IpipProvider
{
    public function getName(): string
    {
        return 'hetzner';
    }

    public function getUrls(): array
    {
        return ['https://whois.ipip.net/AS24940'];
    }

    protected function getXpath(): string
    {
        return '//div[@id="pills-ipv4"]//table//tr/td[contains(text(),"Hetzner Online GmbH")]/../td[1]/a/text()';
    }
}
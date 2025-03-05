<?php

declare(strict_types=1);

namespace App\Provider;


final readonly class AwsProvider extends AbstractProvider
{
    public function getName(): string
    {
        return 'aws';
    }

    public function getCidrList(): iterable
    {
        $decoded = \json_decode(
            $this->getContent('https://ip-ranges.amazonaws.com/ip-ranges.json'),
            true,
            flags: JSON_THROW_ON_ERROR,
        );

        $cidrList = [];
        foreach($decoded['prefixes'] as $prefix) {
            $cidrList[] = $prefix['ip_prefix'];
        }

        sort($cidrList);

        return $cidrList;
    }
}
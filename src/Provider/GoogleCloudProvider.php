<?php

declare(strict_types=1);

namespace App\Provider;

final readonly class GoogleCloudProvider extends AbstractProvider
{
    public function getName(): string
    {
        return 'gcp';
    }

    public function getCidrList(): iterable
    {
        $decoded = json_decode(
            $this->getContent('https://www.gstatic.com/ipranges/cloud.json'),
            true,
            flags: JSON_THROW_ON_ERROR,
        );

        $cidrList = [];
        foreach ($decoded['prefixes'] as $prefix) {
            if (isset($prefix['ipv4Prefix'])) {
                $cidrList[] = $prefix['ipv4Prefix'];
            }
        }

        sort($cidrList);

        return $cidrList;
    }
}
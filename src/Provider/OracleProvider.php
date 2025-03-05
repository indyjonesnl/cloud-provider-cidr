<?php

declare(strict_types=1);

namespace App\Provider;

final readonly class OracleProvider extends AbstractProvider
{
    public function getName(): string
    {
        return 'oracle';
    }

    public function getCidrList(): iterable
    {
        $decoded = json_decode(
            $this->getContent('https://docs.oracle.com/en-us/iaas/tools/public_ip_ranges.json'),
            true,
            flags: JSON_THROW_ON_ERROR,
        );

        $cidrList = [];
        foreach ($decoded['regions'] as $region) {
            foreach($region['cidrs'] as $cidr) {
                $cidrList[] = $cidr['cidr'];
            }
        }

        sort($cidrList);

        return $cidrList;
    }
}
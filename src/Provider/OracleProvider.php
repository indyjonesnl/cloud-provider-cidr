<?php

declare(strict_types=1);

namespace App\Provider;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class OracleProvider implements ProviderInterface
{
    public function __construct(
        private HttpClientInterface $httpClient,
    )
    {
    }

    public function getName(): string
    {
        return 'oracle';
    }

    public function getCidrList(): iterable
    {
        $response = $this->httpClient->request(Request::METHOD_GET, 'https://docs.oracle.com/en-us/iaas/tools/public_ip_ranges.json');
        $decoded = json_decode($response->getContent(), true, flags: JSON_THROW_ON_ERROR);
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
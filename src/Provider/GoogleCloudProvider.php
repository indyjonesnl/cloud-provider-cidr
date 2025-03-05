<?php

declare(strict_types=1);

namespace App\Provider;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class GoogleCloudProvider implements ProviderInterface
{
    public function __construct(
        private HttpClientInterface $httpClient,
    )
    {
    }

    public function getName(): string
    {
        return 'gcp';
    }

    public function getCidrList(): iterable
    {
        $response = $this->httpClient->request(Request::METHOD_GET, 'https://www.gstatic.com/ipranges/cloud.json');
        $decoded = json_decode($response->getContent(), true, flags: JSON_THROW_ON_ERROR);
        $cidrList = [];
        foreach($decoded['prefixes'] as $prefix) {
            if (isset($prefix['ipv4Prefix'])) {
                $cidrList[] = $prefix['ipv4Prefix'];
            }
        }

        sort($cidrList);

        return $cidrList;
    }
}
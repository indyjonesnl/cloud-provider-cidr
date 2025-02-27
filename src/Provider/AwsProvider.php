<?php

declare(strict_types=1);

namespace App\Provider;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class AwsProvider implements ProviderInterface
{
    public function __construct(
        private HttpClientInterface $httpClient,
    )
    {
    }

    public function getName(): string
    {
        return 'AWS';
    }

    public function getCidrList(): iterable
    {
        $response = $this->httpClient->request(Request::METHOD_GET, 'https://ip-ranges.amazonaws.com/ip-ranges.json');
        $decoded = \json_decode($response->getContent(), true, flags: JSON_THROW_ON_ERROR);
        $cidrList = [];
        foreach($decoded['prefixes'] as $prefix) {
            $cidrList[] = $prefix['ip_prefix'];
        }
        sort($cidrList);
        return $cidrList;
    }
}
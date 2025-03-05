<?php

declare(strict_types=1);

namespace App\Provider;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class CloudflareProvider implements ProviderInterface
{
    public function __construct(
        private HttpClientInterface $httpClient,
    )
    {
    }

    public function getName(): string
    {
        return 'cloudflare';
    }

    public function getCidrList(): iterable
    {
        $response = $this->httpClient->request(Request::METHOD_GET, 'https://www.cloudflare.com/ips-v4');
        $cidrList = explode(PHP_EOL, $response->getContent());
        sort($cidrList);
        return $cidrList;
    }
}
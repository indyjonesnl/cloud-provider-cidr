<?php

declare(strict_types=1);

namespace App\Provider;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract readonly class AbstractProvider implements ProviderInterface
{
    protected const string IP_REGEX = '/([0-9]{1,3}\.){3}[0-9]{1,3}($|\/(3[012]|[12][0-9]|[1-9]))/';

    public function __construct(
        private HttpClientInterface $httpClient,
    )
    {
    }

    public function downloadToFile(string $filename): int
    {
        $cidrList = $this->getCidrList();
        file_put_contents($filename, implode(PHP_EOL, $cidrList));

        return count($cidrList);
    }

    protected function getContent(string $path): string
    {
        return $this->httpClient->request(
            Request::METHOD_GET,
            $path,
        )->getContent();
    }
}
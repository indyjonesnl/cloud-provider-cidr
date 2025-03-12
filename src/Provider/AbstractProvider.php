<?php

declare(strict_types=1);

namespace App\Provider;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        $response = $this->httpClient->request(
            Request::METHOD_GET,
            $path,
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Accept-Encoding' => 'gzip',
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; rv:109.0) Gecko/20100101 Firefox/115.',
                ],
            ],
        );

        if (
            $response->getStatusCode() === Response::HTTP_OK &&
            array_key_exists('content-encoding', $response->getHeaders()) &&
            in_array('gzip', $response->getHeaders()['content-encoding'])
        ) {
            return gzdecode($response->getContent());
        }

        return $response->getContent();
    }
}
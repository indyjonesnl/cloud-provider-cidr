<?php

declare(strict_types=1);

namespace App\Provider;

use Exception;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class AzureProvider implements ProviderInterface
{
    public function __construct(
        private HttpClientInterface $httpClient,
    )
    {
    }

    public function getName(): string
    {
        return 'azure';
    }

    public function getCidrList(): iterable
    {
        $response = $this->httpClient->request(Request::METHOD_GET, 'https://www.microsoft.com/en-us/download/details.aspx?id=56519');
        $crawler = new Crawler($response->getContent());
        $elements = $crawler->filterXPath('//a[contains(@class,"btn btn-primary")]');

        if ($elements->count() === 0) {
            throw new Exception('Unable to find button element.');
        }

        $response = $this->httpClient->request(Request::METHOD_GET, $elements->first()->attr('href'));
        $decoded = json_decode($response->getContent(), true, flags: JSON_THROW_ON_ERROR);
        $cidrList = [];
        foreach($decoded['values'] as $value) {
            if (isset($value['properties'])) {
                if (isset($value['properties']['addressPrefixes'])) {
                    foreach($value['properties']['addressPrefixes'] as $address) {
                        if (preg_match('/([0-9]{1,3}\.){3}[0-9]{1,3}($|\/([1-9]|[12][0-9]|3[012]))/', $address, $matches)) {
                            $cidrList[] = $matches[0];
                        }
                    }
                }
            }
        }

        sort($cidrList);

        return $cidrList;
    }
}
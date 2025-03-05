<?php

declare(strict_types=1);

namespace App\Provider;

use Exception;
use Symfony\Component\DomCrawler\Crawler;

final readonly class AzureProvider extends AbstractProvider
{
    public function getName(): string
    {
        return 'azure';
    }

    public function getCidrList(): iterable
    {
        $content = $this->getContent('https://www.microsoft.com/en-us/download/details.aspx?id=56519');
        $crawler = new Crawler($content);
        $elements = $crawler->filterXPath('//a[contains(@class,"btn btn-primary")]');

        if ($elements->count() === 0) {
            throw new Exception('Unable to find button element.');
        }

        $decoded = json_decode($this->getContent($elements->first()->attr('href')), true, flags: JSON_THROW_ON_ERROR);
        $cidrList = [];
        foreach ($decoded['values'] as $value) {
            if (isset($value['properties'])) {
                if (isset($value['properties']['addressPrefixes'])) {
                    foreach ($value['properties']['addressPrefixes'] as $address) {
                        if (preg_match(self::IP_REGEX, $address, $matches)) {
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